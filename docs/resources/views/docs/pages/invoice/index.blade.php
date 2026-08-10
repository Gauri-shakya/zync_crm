<h1>Zyn CRM Invoice Pro</h1>
<p>The <strong>Invoice</strong> module is a professional billing system integrated with GST compliance. It allows you to create, manage, and track invoices for your clients with a real-time preview and PDF generation capabilities.</p>

<div class="my-8 rounded-xl overflow-hidden border border-gray-200 shadow-sm bg-white">
    <div class="bg-gray-50 px-4 sm:px-6 py-4 border-b border-gray-200">
        <h3 class="text-gray-900 font-bold m-0 text-lg sm:text-xl">Invoice Dashboard & History</h3>
    </div>
    <div class="p-4 sm:p-6">
        <p>The main screen displays your <strong>Invoice History</strong>. Here you can see a list of all locally saved invoices, their issue dates, total amounts, and current statuses. You can quickly <strong>Search by client</strong> or filter the list by <strong>Status</strong> (e.g., Paid, Pending, Overdue).</p>
    </div>
</div>

<h2>Creating a Professional Invoice</h2>
<p>Click the <strong>"+ Create Invoice"</strong> button to open the <strong>Invoice Pro</strong> builder. This detailed form is divided into several logical sections to ensure your invoices are accurate and GST-compliant.</p>

<div class="space-y-8 my-10">
    <!-- Client Info -->
    <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded flex items-center justify-center">
                <i data-lucide="user" class="w-5 h-5"></i>
            </div>
            <h4 class="font-bold text-gray-900 m-0">1. Client Information</h4>
        </div>
        <p class="text-sm text-gray-600">Enter the recipient's details, including their <strong>Company Name</strong>, <strong>Email</strong>, and <strong>Address & GSTIN</strong>. This information will appear in the "Bill To" section of the final document.</p>
    </div>

    <!-- Invoice Settings -->
    <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 bg-purple-100 text-purple-600 rounded flex items-center justify-center">
                <i data-lucide="settings" class="w-5 h-5"></i>
            </div>
            <h4 class="font-bold text-gray-900 m-0">2. Invoice Settings</h4>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
            <p><strong>Invoice # & Date:</strong> Set your unique reference number and issue date.</p>
            <p><strong>GST Slab & Mode:</strong> Choose the applicable tax percentage (e.g., 18%) and mode (e.g., CGST+SGST or IGST).</p>
            <p><strong>Currency & Discount:</strong> Select your billing currency and apply flat discounts if needed.</p>
            <p><strong>Description:</strong> Add a brief internal note or specific instructions for this invoice.</p>
        </div>
    </div>

    <!-- Invoice Items -->
    <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm border-l-4 border-l-green-500">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 bg-green-100 text-green-600 rounded flex items-center justify-center">
                <i data-lucide="list" class="w-5 h-5"></i>
            </div>
            <h4 class="font-bold text-gray-900 m-0">3. Invoice Items</h4>
        </div>
        <p class="text-sm text-gray-600">This is where you list your services or products. Click <strong>"+ Add"</strong> to insert new rows. For each item, specify the <strong>Description</strong>, <strong>Service Type</strong>, <strong>Qty</strong>, and <strong>Rate</strong>. The system will automatically calculate the total amount for each row.</p>
    </div>

    <!-- Admin Signature -->
    <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 bg-orange-100 text-orange-600 rounded flex items-center justify-center">
                <i data-lucide="pen-tool" class="w-5 h-5"></i>
            </div>
            <h4 class="font-bold text-gray-900 m-0">4. Admin Signature</h4>
        </div>
        <p class="text-sm text-gray-600">Upload your digital signature (PNG, JPG, or WebP). This signature will be placed in the "Authorized Signature" section of the invoice for professional validation.</p>
    </div>
</div>

<h2>Live Preview & Finalization</h2>
<p>As you fill out the form, the <strong>Live Preview</strong> in the center of the screen updates instantly. This allows you to see exactly how the "Bill To" details, tax calculations, and terms and conditions will look on the printed document.</p>

<div class="bg-gray-900 text-white p-6 sm:p-10 rounded-xl my-8">
    <h3 class="text-blue-400 mt-0">Final Actions</h3>
    <div class="flex flex-col md:flex-row gap-6 mt-4">
        <div class="flex-1">
            <h4 class="font-bold m-0 text-white">Save Invoice</h4>
            <p class="text-sm text-gray-400 mt-2">Stores the record in your local CRM database for future tracking and reporting.</p>
        </div>
        <div class="flex-1 border-l border-gray-700 pl-6">
            <h4 class="font-bold m-0 text-white">Download PDF</h4>
            <p class="text-sm text-gray-400 mt-2">Generates a high-quality PDF document that you can email directly to your client.</p>
        </div>
    </div>
</div>

<div class="p-4 bg-blue-50 border border-blue-100 rounded-lg text-sm text-blue-800 italic">
    <strong>Pro-Tip:</strong> Use the "Edit Company" button on the dashboard to set your default company logo and address so they appear automatically on every new invoice.
</div>
