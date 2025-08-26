 <style>
     @page {
         margin: 0px;
     }

     body {
         font-family: DejaVu Sans, sans-serif;
         background-size: 100% 100%;
         background-repeat: no-repeat;
         background-position: 0 0;
         margin: 0;
         padding: 175px 20px 120px 20px;
     }

     .invoice-invoice-container {
         width: 210mm;
         max-width: 100vw;
         margin: 0 auto;
         background: #fff;
         padding: 2rem;
         border-radius: 12px;
         box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
         font-family: 'Segoe UI', Arial, sans-serif;
     }

     .invoice-header {
         display: flex;
         justify-content: space-between;
         align-items: flex-start;
         margin-bottom: 2rem;
     }

     .invoice-logo {
         align-self: flex-start;
         width: 200px;
         height: 100px;
         /* background: #e3f2fd; */
         display: flex;
         align-items: center;
         justify-content: center;
         font-size: 2rem;
         font-weight: bold;
         color: #1976d2;
         border-radius: 10px;
         margin-bottom: .9rem;
         padding-left: 11px;
     }

     .invoice-logo img {
         max-width: 100%;
         max-height: 100%;
         display: block;
         margin: 0 auto;
     }

     .invoice-company-details {
         color: #333;
         font-size: 0.97rem;
         line-height: 1.3;
         margin-left: 0.5rem;
     }

     .invoice-title-block {
         text-align: right;
         min-width: 137px;
         margin-top: 28px;
     }

     .invoice-title {
         font-size: 2.2rem;
         font-weight: bold;
         color: #1976d2;
         margin-bottom: 1.5rem;
     }

     .invoice-title-block .invoice-meta {
         font-size: 1rem;
         color: #333;
         margin-bottom: 0.2rem;
     }

     .invoice-bill-section {
         margin-top: 6rem;
         margin-bottom: 3.5rem;
     }

     .invoice-bill-label {
         color: #1976d2;
         font-weight: bold;
         font-size: 1rem;
         /* letter-spacing: 1px; */
     }

     .invoice-client-name {
         font-weight: bold;
         font-size: 1.15rem;
         color: #222;
     }

     .invoice-table {
         width: 100%;
         border-collapse: collapse;
         margin-bottom: 2rem;
     }

     .invoice-table th {
         background: #1976d2;
         color: #fff;
         font-weight: bold;
         padding: 0.8rem;
         border: none;
         font-size: .9rem;
     }

     .invoice-table th:not(:first-child),
     .invoice-table td:not(:first-child) {
         text-align: center;
     }

     .invoice-table th:first-child,
     .invoice-table td:first-child {
         text-align: left;
         width: 50%;
     }

     .invoice-table td {
         padding: 0.8rem;
         border-bottom: 1px solid #e0e0e0;
         font-size: .9rem;
         vertical-align: middle;
     }

     .invoice-table tr:last-child td {
         border-bottom: none;
     }

     .invoice-table td.amount,
     .invoice-table td.qty,
     .invoice-table td.unit {
         text-align: center;
     }

     .invoice-summary {
         text-align: right;
         margin-bottom: 2rem;
     }

     .invoice-summary-row {
         font-size: 1.1rem;
         margin-bottom: 0.3rem;
     }

     .invoice-summary-row.total {
         font-weight: bold;
         color: #1976d2;
         font-size: 1.3rem;
     }

     .invoice-footer {
         margin-top: 5rem;
         text-align: right;
         margin-bottom: 9rem;
     }

     .invoice-signature {
         color: #1976d2;
         font-weight: bold;
         font-size: 1.1rem;
         /* border-top: 2px solid #1976d2; */
         /* width: 220px; */
         margin: 3rem 3rem 0 auto;
         padding-top: 1rem;
     }

     .thanks-note {
         text-align: center;
         font-size: .9rem;
         color: #1976d2;
         margin-bottom: 3rem;
     }

     /* @media (max-width: 768px) {
            .invoice-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .invoice-title-block {
                text-align: left;
                margin-top: .9rem;
            }

            .invoice-summary {
                text-align: left;
            }
        } */
 </style>


 <div class="invoice-invoice-container">
     <div class="invoice-header">
         <div>
             <div class="invoice-logo" style="margin-bottom: 0.5rem;">
                 <img src="{{ public_path('assets/images/logo-h.png') }}" alt="Logo">
             </div>
             <div class="invoice-company-details">
                 Pivot for business and administrative solutions<br>
                 Tax ID : 636-336-867<br>
                 Reg# : 17090<br>
                 696 El Houria st. - Louran<br>
                 Alexandria - Egypt<br>
                 info@pivotcoworkingspace.com<br>
                 +20 122 642 0549 / +20 03 580 5611
             </div>
         </div>
         <div class="invoice-title-block">
             <div class="invoice-title">INVOICE</div>
             <div class="invoice-meta"><b>INVOICE # :</b> {{ $invoice->inv_number }}</div>
             <div class="invoice-meta"><b>DATE :</b> {{ $invoice->inv_date }}</div>
         </div>
     </div>
     <div class="invoice-bill-section">
         <div class="invoice-bill-label">FOR</div>
         <div class="invoice-client-name">{{ $invoice->inv_for }}</div>
     </div>
     <table class="invoice-table">
         <thead>
             <tr>
                 <th>Item</th>
                 <th class="qty">Qty</th>
                 <th class="unit">Unit Amount</th>
                 <th>Discount</th>
                 <th class="amount">Amount</th>
             </tr>
         </thead>
         <tbody>
             @foreach ($invoice->invoiceItems as $item)
                 <tr>
                     <td>{{ $item['item_name'] }}</td>
                     <td class="qty">{{ $item['item_qty'] }}</td>
                     <td class="unit">{{ $item['item_unit_amount'] }} LE</td>
                     <td>{{ $item['item_discount'] ?? '-' }}</td>
                     <td class="amount">{{ $item['item_total_amount'] }} LE</td>
                 </tr>
             @endforeach
         </tbody>
     </table>
     <div class="invoice-summary">
         <div class="invoice-summary-row"><b>Subtotal :</b> {{ $invoice->inv_amount }} LE</div>
         <div class="invoice-summary-row"><b>Tax VAT :</b> {{ $invoice->tax_vat }} LE</div>
         <div class="invoice-summary-row total">Total : {{ $invoice->inv_total_amount }} LE</div>
     </div>
     <div class="invoice-footer">
         <div class="invoice-signature">Signature</div>
     </div>

     <div class="thanks-note">
         THANK YOU FOR YOUR BUSINESS!
     </div>

 </div>
