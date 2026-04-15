// Registrar componente report-form

Vue.component('report-form', {
    props: ['user', 'customer', 'category', 'vendor'],

    template: `
    <div class="col-md-12">

        <div class="row">

            <div class="col-md-4">
                <label>Chose Report Type *</label>
                <select name="type" class="form-control" required>
                    <option value="">Select Type</option>
                    <option value="sell">Sell</option>
                    <option value="invoice">Invoice</option>
                    <option value="due">Due</option>
                    <option value="profit">Profit</option>
                    <option value="stock">Stock</option>
                </select>
            </div>

            <div class="col-md-4">
                <label>Date From *</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label>Date To *</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>

        </div>

        <br>

        <div class="row">

            <div class="col-md-4">
                <label>Chose Category (optional)</label>
                <select name="category_id" class="form-control">
                    <option value="">Select Category</option>
                    <option v-for="c in category" :value="c.id">
                        {{ c.name }}
                    </option>
                </select>
            </div>

            <div class="col-md-4">
                <label>Chose Vendor (optional)</label>
                <select name="vendor_id" class="form-control">
                    <option value="">Select Vendor</option>
                    <option v-for="v in vendor" :value="v.id">
                        {{ v.name }}
                    </option>
                </select>
            </div>

            <div class="col-md-4">
                <label>Customer (optional)</label>
                <select name="customer_id" class="form-control">
                    <option value="">Select Customer</option>
                    <option v-for="c in customer" :value="c.id">
                        {{ c.customer_name }}
                    </option>
                </select>
            </div>

        </div>

        <br>

        <div class="row">

            <div class="col-md-4">
                <label>User (optional)</label>
                <select name="user_id" class="form-control">
                    <option value="">Select User</option>
                    <option v-for="u in user" :value="u.id">
                        {{ u.name }}
                    </option>
                </select>
            </div>

        </div>

    </div>
    `
});


// Crear instancia Vue
new Vue({
    el: '#inventory'
});