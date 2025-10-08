import express from "express";
import cors from "cors";

const app = express();
app.use(cors());
app.use(express.json()); // <-- replaces body-parser

app.post("/payment/initiate", (req, res) => {
  console.log("Incoming request:", req.body);

  const { amount, payment_method } = req.body || {};

  if (payment_method === "paytm") {
    const orderId = "ORDER" + Date.now();
    return res.json({
      redirect_url: `https://securegw-stage.paytm.in/theia/processTransaction?ORDER_ID=${orderId}&TXN_AMOUNT=${amount}`,
    });
  }

  if (payment_method === "phonepe") {
    const transactionId = "TXN" + Date.now();
    return res.json({
      redirect_url: `https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay?transactionId=${transactionId}&amount=${amount}`,
    });
  }

  return res.status(400).json({ error: "Invalid Payment Method" });
});

const PORT = 3000;
app.listen(PORT, () => {
  console.log(`✅ Server running at http://localhost:${PORT}`);
});
