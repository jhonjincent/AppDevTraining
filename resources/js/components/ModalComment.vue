<template>
    <div class="modal fade" id="modalComment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Comment</h5>
        <button type="button" class="close" @click="close()" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>

          <!-- Comments -->
          <div class="form-group" :class="{ ' has-danger' : errors.com }">
            <textarea class="form-control" v-model="comment.com" :class="{ 'is-invalid' : errors.com }" id="com" placeholder="Enter Comment Here"></textarea>
            <div v-if="errors.com" class="invalid-feedback">{{ errors.com[0] }}</div>
          </div>
          
        </form>
      </div>

      <div class="modal-footer">
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
        reportId: {
            type: "",
            default: false
        },
    comment: {
      type: Object,
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
                $('#modalComment')
                .modal({
                    backdrop: "static",
                    keyboard: false
                });
            }
            else{
                $('#modalComment')
                .modal("hide");
            }
        }
        
    },

    methods: {
        close(){
            this.$emit('close', false);
            $('#modalComment').modal("hide");
            this.dowloading = false
        },

        store(){
            console.log('check if store is triggered')
            let formData = new FormData();
            if (this.comment.com) formData.append('com', this.comment.com);
            if (this.reportId) formData.append('reportId', this.reportId);
            axios.post(`/store-comment`,
            formData, { 
            headers: {
            'Content-Type': 'multipart/form-data'
            }
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
    }
}
</script>
