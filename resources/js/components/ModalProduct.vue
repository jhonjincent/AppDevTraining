<template>
    <div class="modal fade" id="modalProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Product</h5>
        <button type="button" class="close" @click="close()" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group" :class="{ ' has-danger' : errors.name }">
            <label class="col-form-label">Product Name:</label>
            <input type="text" :class="{ 'is-invalid' : errors.name }" class="form-control acc_format" id="name"  v-model="product.name" placeholder="Enter Name">
            <div v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</div>
          </div>

          <div class="form-group" :class="{ ' has-danger' : errors.detail }">
            <label class="col-form-label">Details:</label>
            <textarea class="form-control" v-model="product.detail" :class="{ 'is-invalid' : errors.detail }" id="message-text"></textarea>
            <div v-if="errors.detail" class="invalid-feedback">{{ errors.detail[0] }}</div>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" @click="close()" data-dismiss="modal">Close</button>
        <button type="button" v-if="isForEdit === true" class="btn btn-primary" @click="update(product.id)">Update</button> 
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

        product: {
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
                $('#modalProduct')
                .modal({
                    backdrop: "static",
                    keyboard: false
                });
            }
            else{
                $('#modalProduct')
                .modal("hide");
            }
        }
        
    },

    methods: {
        close(){
            this.$emit('close', false);
            $('#modalProduct').modal("hide");
            this.dowloading = false
        },

        store(){
            console.log('check if store is triggered')
            axios.post('api/products',{
                name: this.product.name,
                detail: this.product.detail
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
          axios.patch(`api/products/${id}`, {
                name: this.product.name,
                detail: this.product.detail
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
