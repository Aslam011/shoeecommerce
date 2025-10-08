<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('order')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $baseData = $request->only(['title', 'description', 'button_text', 'button_link']);
        $isActive = $request->has('is_active');
        $order = $request->input('order', 0);

        if ($request->hasFile('images')) {
            $sliderCount = 0;
            foreach ($request->file('images') as $image) {
                $data = $baseData;
                $data['is_active'] = $isActive;
                $data['order'] = $order + $sliderCount;
                $data['image'] = $image->store('sliders', 'public');
                
                Slider::create($data);
                $sliderCount++;
            }
        }

        return redirect()->route('admin.sliders.index')->with('success', count($request->file('images')) . ' slider(s) created successfully!');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $data = $request->only(['title', 'description', 'button_text', 'button_link', 'order']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        $slider->update($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider updated successfully!');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }
        
        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'Slider deleted successfully!');
    }
}
