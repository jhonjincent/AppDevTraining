<template>
    <div class="modal fade" id="modalEmployee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Employee</h5>
        <button type="button" class="close" @click="close()" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group" :class="{ ' has-danger' : errors.first_name }">
            <label class="col-form-label">First Name:</label>
            <input type="text" :class="{ 'is-invalid' : errors.first_name }" class="form-control acc_format" id="first_name"  v-model="employee.first_name" placeholder="Enter First Name">
            <div v-if="errors.first_name" class="invalid-feedback">{{ errors.first_name[0] }}</div>
          </div>

         <div class="form-group" :class="{ ' has-danger' : errors.last_name }">
            <label class="col-form-label">Last Name:</label>
            <input type="text" :class="{ 'is-invalid' : errors.last_name }" class="form-control acc_format" id="last_name"  v-model="employee.last_name" placeholder="Enter Last Name">
            <div v-if="errors.last_name" class="invalid-feedback">{{ errors.last_name[0] }}</div>
          </div>

          <div class="form-group" :class="{ ' has-danger' : errors.position }">
            <label class="col-form-label">Position:</label>
            <input type="text" :class="{ 'is-invalid' : errors.position }" class="form-control acc_format" id="position"  v-model="employee.position" placeholder="Position">
            <div v-if="errors.position" class="invalid-feedback">{{ errors.position[0] }}</div>
          </div>

          <div class="form-group" :class="{ ' has-danger' : errors.date_hired }">
            <label class="col-form-label">Date Hired:</label>
            <input type="date" :class="{ 'is-invalid' : errors.date_hired }" class="form-control acc_format" id="date_hired"  v-model="employee.date_hired" placeholder="Date Hired">
            <div v-if="errors.date_hired" class="invalid-feedback">{{ errors.date_hired[0] }}</div>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" @click="close()" data-dismiss="modal">Close</button>
        <button type="button" v-if="isForEdit === true" class="btn btn-primary" @click="update(employee.id)">Update</button> 
        <button type="button" class="btn btn-primary" @click="store()">Submit</button>
      </div>
    </div>
  </div>
</div> 
</template>

<script>

export default {
    props: {
        show: {
            type: Boolean,
            default: false
        },

        employee: {
      type: Object,
      default: {}
    },

    isForEdit: {
      type: Boolean,
      default: {}
    },
    },

    data(){
        return{
            errors: [],
           
        }
    },

    watch: {
        show(){
            if(this.show === true){
                $('#modalEmployee')
                .modal({
                    backdrop: "static",
                    keyboard: false
                });
            }
            else{
                $('#modalEmployee')
                .modal("hide");
            }
        }
        
    },

    methods: {
        close(){
            this.$emit('close', false);
            $('#modalEmployee').modal("hide");
            this.dowloading = false
        },

        store(){
            console.log('check if store is triggered')
            axios.post('api/employees',{
                first_name: this.employee.first_name,
                last_name: this.employee.last_name,
                position: this.employee.position,
                date_hired: this.employee.date_hired

            })
            .then(response => {
                if(response.status === 200 || response.status === 201){
                    this.close();
                    this.$emit('return', response.data)
                }
            })
            .catch(error =>{
                if(error.response.status === 422){
                    this.errors = error.response.data.errors;
                }
            })
        },

        update(id){
          axios.patch(`api/employees/${id}`, {
                first_name: this.employee.first_name,
                last_name: this.employee.last_name,
                position: this.employee.position,
                date_hired: this.employee.date_hired

        })
        .then(response => {
                if(response.status === 200 || response.status === 201){
                    this.close();
                    this.$emit('returnUpdate', response.data)
                    this.$emit('resetEdit', false)
                }
            })
            .catch(error =>{
                if(error.response.status === 422){
                    this.errors = error.response.data.errors;
                }
            })
        },


    }
}
</script>
