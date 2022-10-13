<template>
<div>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h1 class="h2">Employees</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button type="button" @click="openModal()" class="btn btn-sm btn-outline-primary">Add New Employee</button>
            </div> 
        </div> 

        <table class="table">
            <thead>
                <tr>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Position</th>
                <th scope="col">Date Hired</th>
                <th scope="col">Option</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="loading === false && employees" v-for="(employee,i) in employees.data" :key="i">
                    <td>{{ employee.first_name }}</td>
                    <td>{{ employee.last_name }}</td>
                    <td>{{ employee.position }}</td>
                    <td>{{ employee.date_hired }}</td>
                    <td>
                         <button @click="modifyEmployee(employee)" class="btn btn-primary">Edit</button>
                        <button @click="deleteEmployee(i, employee.id)" class="btn btn-danger">Delete</button>
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
                    <button :disabled="employees.current_page == 1" @click="prevPage()" class="btn btn-primary btn-sm btn-fill"> Previous </button>
                        <span class="text-dark">Page {{ employees.current_page  }} of {{ employees.last_page }}</span>
                    <!-- <button :disabled="!showNextLink()" class="btn btn-default btn-sm btn-fill"> Next </button> -->
                    <button  @click="nextPage()" :disabled="employees.current_page == employees.last_page" class="btn btn-primary btn-sm btn-fill"> Next </button>
                </div>
                <div class="col-6 text-right">
                    <span>{{ employees.total }} Total</span>
                </div>
            </div>

            <!-- modal component -->
            <modal-employee 
                :employee="employee" 
                :isForEdit="isForEdit"
                @resetEdit="isForEdit = $event"
                @returnEmployee="updateEmployee($event)"
                @return="pushNewEmployee($event)"
                @close="show = $event"
                :show="show">
            </modal-employee> 


</div>
</template>
<script>
import ModalEmployee from '../../components/ModalEmployee.vue';
export default{
    data(){
        return{
            show: false,
            loading: false,
            employees: [],
            search: "",
            current_page: 1,
            last_page_url: "",
            next_page_url: "",
            prev_page_url: "",
            isForEdit: false,
            employee: {},
            
        }
    },

    components: {
        ModalEmployee,
    },

    mounted() {
            console.log('Component mounted.')
            this.fetchEmployees();
        },

    methods: {
        openModal(){
            this.show = !this.show;
        },

        pushNewEmployee(event){
            this.employees.data.unshift(event);
        },

        fetchEmployees(){
            this.loading = true;
            axios.get('/api/employees')
            .then(response => {
                console.log('response: ', response.data)
                this.employees = response.data
                this.loading = false;
            })
        },

        deleteEmployee(index, id) {
                axios.delete(`/api/employees/${id}`)
                .then(response => {
                    if(response.status === 200 || response.status === 201) {
                        this.employees.data.splice(index,1);
                    }
                })
            }, 
            
            modifyEmployee(employee) {
                this.show = !this.show;
                this.employee = employee;
                this.isForEdit = true;
            },

            updateEmployee(event) {
                let findEmployee = this.employee.data.findIndex(x => x.id === event.id);
                this.employee.data[findEmployee] = event;
            },

        prevPage() {
                this.loading = true
                axios.get(`${this.employees.prev_page_url}`)
                .then(response => {
                    this.employees = response.data;
                    this.loading = false;
                });
            },

            nextPage() {
                this.loading = true
                axios.get(`${this.employees.next_page_url}`)
                .then(response => {
                    console.log('check response ter: ', response)
                    this.employees = response.data
                    this.loading = false;
                });
            },
    }
}
</script>
