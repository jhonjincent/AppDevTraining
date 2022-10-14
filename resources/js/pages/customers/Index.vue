<template>
<!-- eslint-disable vue/no-use-v-if-with-v-for,vue/no-confusing-v-for-v-if -->
<div>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h1 class="h2">All Customers</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button type="button" @click="openModal()" class="btn btn-sm btn-outline-primary">Add New Customer</button>
            </div> 
        </div> 

        <table class="table">
            <thead>
                <tr>
                <th scope="col">Name</th>
                <th scope="col">Branch</th>
                <th scope="col">Address</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="loading === false && customers" v-for="(customer,i) in customers.data" :key="i">
                    <td><a :href="'/storage/' + customer.custattachment.path" target="_blank">{{ customer.name }}</a></td>
                    <td>{{ customer.branch }}</td>
                    <td>{{ customer.address.description }}</td>
                    <td>
                         <button @click="modifyCustomer(customer)" class="btn btn-primary">Edit</button>
                        <button @click="deleteCustomer(i, customer.id)" class="btn btn-danger">Delete</button>
                    </td>
                </tr>

                <tr v-if="loading === true">
                    <td colspan="2">
                        <div class="spiner-example">
                            <!-- <div class="sk-spinner sk-spinner-double-bounce">
                                <div class="sk-double-bounce1"></div>
                                <div class="sk-double-bounce2"></div>
                            </div> -->
                            <p class="text-center">
                                Please wait...
                            </p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="row mb-3">
                <div class="col-6">
                    <button :disabled="customers.current_page == 1" @click="prevPage()" class="btn btn-primary btn-sm btn-fill"> Previous </button>
                        <span class="text-dark">Page {{ customers.current_page  }} of {{ customers.last_page }}</span>
                    <!-- <button :disabled="!showNextLink()" class="btn btn-default btn-sm btn-fill"> Next </button> -->
                    <button  @click="nextPage()" :disabled="customers.current_page == customers.last_page" class="btn btn-primary btn-sm btn-fill"> Next </button>
                </div>
                <div class="col-6 text-right">
                    <span>{{ customers.total }} Total</span>
                </div>
            </div>

            <!-- modal component -->
            <modal-customer 
                :customer="customer" 
                :isForEdit="isForEdit"
                @resetEdit="isForEdit = $event"
                @returnCustomer="updateCustomer($event)"
                @return="pushNewCustomer($event)"
                @close="show = $event"
                :show="show">
            </modal-customer> 


</div>
</template>
<script>
import ModalCustomer from '../../components/ModalCustomer.vue';
export default{
    data(){
        return{
            show: false,
            loading: false,
            customers: [],
            search: "",
            current_page: 1,
            last_page_url: "",
            next_page_url: "",
            prev_page_url: "",
            isForEdit: false,
            customer: {},
            
        }
    },

    components: {
        ModalCustomer,
    },

    mounted() {
            console.log('Component mounted.')
            this.fetchCustomers();
        },

    methods: {
        openModal(){
            this.show = !this.show;
        },

        pushNewCustomer(event){
            this.customers.data.unshift(event);
        },

        fetchCustomers(){
            this.loading = true;
            axios.get('/api/customers')
            .then(response => {
                console.log('response: ', response.data)
                this.customers = response.data
                this.loading = false;
            })
        },

        deleteCustomer(index, id) {
                axios.delete(`/api/customers/${id}`)
                .then(response => {
                    if(response.status === 200 || response.status === 201) {
                        this.customers.data.splice(index,1);
                    }
                })
            }, 
            
            modifyCustomer(customer) {
                this.show = !this.show;
                this.customer = customer;
                this.isForEdit = true;
            },

            updateCustomer(event) {
                let findCustomer = this.customer.data.findIndex(x => x.id === event.id);
                this.customer.data[findCustomer] = event;
            },

        prevPage() {
                this.loading = true
                axios.get(`${this.customers.prev_page_url}`)
                .then(response => {
                    this.customers = response.data;
                    this.loading = false;
                });
            },

            nextPage() {
                this.loading = true
                axios.get(`${this.customers.next_page_url}`)
                .then(response => {
                    console.log('check response ter: ', response)
                    this.customers = response.data
                    this.loading = false;
                });
            },
    }
}
</script>
