<template>
    <div class="modal fade" id="modalCustomer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Customer</h5>
        <button type="button" class="close" @click="close()" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>

          <!-- Customer Name -->
          <div class="form-group" :class="{ ' has-danger' : errors.name }">
            <label class="col-form-label">Customer Name:</label>
            <input type="text" :class="{ 'is-invalid' : errors.name }" class="form-control acc_format" id="name"  v-model="customer.name" placeholder="Enter Name">
            <div v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</div>
          </div>

          <!-- Branch -->
          <div class="form-group" :class="{ ' has-danger' : errors.branch }">
            <label class="col-form-label">Branch:</label>
            <input type="text" :class="{ 'is-invalid' : errors.branch }" class="form-control acc_format" id="branch"  v-model="customer.branch" placeholder="Enter Branch">
            <div v-if="errors.branch" class="invalid-feedback">{{ errors.branch[0] }}</div>
          </div>

          <!-- Types -->
          <div class="form-group" :class="{ ' has-danger' : errors.address }">
            <label class="col-form-label">Address:</label>
            <input type="text" :class="{ 'is-invalid' : errors.address }" class="form-control acc_format" id="description"  v-model="customer.address" placeholder="Enter Description">
            <div v-if="errors.address" class="invalid-feedback">{{ errors.address[0] }}</div>
          </div>

          <!-- Attachments -->
          <div class="form-group">
          <label>Attachment</label>
          <div></div>
          <div class="custom-file">
          <input type="file" ref="custattachment" @change="handleFileAttachment()" accept="image/*,application/pdf" :class="{ 'is-invalid' : errors.custattachment }">
          <div v-if="errors.custattachment" class="invalid-feedback">{{ errors.custattachment[0] }}</div>
          </div>
          </div>
          
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" @click="close()" data-dismiss="modal">Close</button>
        <button type="button" v-if="isForEdit === true" class="btn btn-primary" @click="update(customer.id)">Update</button> 
        <button type="button" v-if="isForEdit === false" class="btn btn-primary" @click="store()">Submit</button>
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

        customer: {
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
                $('#modalCustomer')
                .modal({
                    backdrop: "static",
                    keyboard: false
                });
            }
            else{
                $('#modalCustomer')
                .modal("hide");
            }
        }
        
    },

    methods: {
        close(){
            this.$emit('close', false);
            $('#modalCustomer').modal("hide");
            this.dowloading = false
        },

        store(){
            console.log('check if store is triggered')

            let formData = new FormData();
            let custattachment = this.$refs['custattachment']['files'][0];
            formData.append('custattachment', custattachment);
            if (this.customer.name) formData.append('name', this.customer.address);
            if (this.customer.branch) formData.append('branch', this.customer.branch);
            if (this.customer.address) formData.append('address', this.customer.address);

            axios.post(`api/customers`,
            formData, {
            headers: {
            'Content-Type': 'multipart/form-data'
            }
            })

            // axios.post('api/customers',{
            //     name: this.customer.name,
            //     branch: this.customer.branch,
            //     address: this.customer.address,

            // })
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
          axios.patch(`api/customers/${id}`, {
                name: this.customer.name,
                branch: this.customer.branch,
                
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

        handleFileAttachment(){
        this.custattachment = this.$refs['custattachment']['files'][0];
        },
    }
}
</script>
