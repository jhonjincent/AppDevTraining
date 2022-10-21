<template>
<!-- eslint-disable vue/no-use-v-if-with-v-for,vue/no-confusing-v-for-v-if -->
<div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Department   
                <button type="button" @click="openModal()" class="btn btn-sm btn-outline-primary" style="float: right;">Add New Department</button>
            </div>  

        <table class="table">
            <thead>
                <tr>
                <th scope="col">Department ID </th>
                <th scope="col">Department Name</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="loading === false && departments" v-for="(department,i) in departments.data" :key="i">
                    <td>{{ department.id }}</td>
                    <td>{{ department.name }}</td>
                    <td>
                        <button @click="modifyDepartment(department)" class="btn btn-primary">Edit</button>
                        <button @click="deleteDepartment(i, department.id)" class="btn btn-danger">Delete</button>
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
                    <button :disabled="departments.current_page == 1" @click="prevPage()" class="btn btn-primary btn-sm btn-fill"> Previous </button>
                        <span class="text-dark">Page {{ departments.current_page  }} of {{ departments.last_page }}</span>
                    <!-- <button :disabled="!showNextLink()" class="btn btn-default btn-sm btn-fill"> Next </button> -->
                    <button  @click="nextPage()" :disabled="departments.current_page == departments.last_page" class="btn btn-primary btn-sm btn-fill"> Next </button>
                </div>
                <div class="col-6 text-right">
                    <span>{{ departments.total }} Total</span>
                </div>
            </div>

            <!-- modal component -->
            <modal-department 
                :department="department" 
                :isForEdit="isForEdit"
                @resetEdit="isForEdit = $event"
                @returnUpdate="updateDepartment($event)"
                @return="pushNewDepartment($event)"
                @close="show = $event"
                :show="show">
            </modal-department>  
            </div>
            </div>
</div>
</div>
</div>
</template>
<script>
import ModalDepartment from '../../components/ModalDepartment.vue';
export default{
    data(){
        return{
            show: false,
            loading: false,
            departments: [],
            search: "",
            current_page: 1,
            last_page_url: "",
            next_page_url: "",
            prev_page_url: "",
            isForEdit: false,
            department: {},
            
        }
    },

    components: {
        ModalDepartment,
    },

    mounted() {
            console.log('Component mounted.')
            this.fetchDepartments();
        },

    methods: {
        openModal(){
            this.show = !this.show;
        },

        pushNewDepartment(event){
            this.departments.data.unshift(event);
        },

        fetchDepartments(){
            this.loading = true;
            axios.get('/api/departments')
            .then(response => {
                console.log('response: ', response.data)
                this.departments = response.data
                this.loading = false;
            })
        },

        deleteDepartment(index, id) {
                axios.delete(`/api/departments/${id}`)
                .then(response => {
                    if(response.status === 200 || response.status === 201) {
                        this.departments.data.splice(index,1);
                    }
                })
            }, 
            
            modifyDepartment(department) {
                this.show = !this.show;
                this.department = department;
                this.isForEdit = true;
            },

            updateDepartment(event) {
                let findDepartment = this.departments.data.findIndex(x => x.id === event.id);
                this.departments.data[findDepartment] = event;
            }, 

        prevPage() {
                this.loading = true
                axios.get(`${this.departments.prev_page_url}`)
                .then(response => {
                    this.departments = response.data;
                    this.loading = false;
                });
            },

            nextPage() {
                this.loading = true
                axios.get(`${this.departments.next_page_url}`)
                .then(response => {
                    console.log('check response ter: ', response)
                    this.departments = response.data
                    this.loading = false;
                });
            },
    }
}
</script>
