<template>
    <div class="modal fade" id="modalReport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Post</h5>
        <button type="button" class="close" @click="close()" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>

          <!-- Titles -->
          <div class="form-group" :class="{ ' has-danger' : errors.title }">
            <input type="text" :class="{ 'is-invalid' : errors.title }" class="form-control acc_format" id="title"  v-model="report.title" placeholder="Enter Title">
            <div v-if="errors.title" class="invalid-feedback">{{ errors.title[0] }}</div>
          </div>

          <!-- Details -->
          <div class="form-group" :class="{ ' has-danger' : errors.detail }">
            <textarea class="form-control" v-model="report.detail" :class="{ 'is-invalid' : errors.detail }" id="message-text" placeholder="What's on your mind?"></textarea>
            <div v-if="errors.detail" class="invalid-feedback">{{ errors.detail[0] }}</div>
          </div>

          <!-- Departments -->
          <div class="form-group" :class="{ ' has-danger' : errors.department }">
            <input type="text" :class="{ 'is-invalid' : errors.department }" class="form-control acc_format" id="department"  v-model="report.department" placeholder="Enter Department">
            <div v-if="errors.department" class="invalid-feedback">{{ errors.department[0] }}</div>
          </div>

          <!-- Companies -->
          <div class="form-group" :class="{ ' has-danger' : errors.company }">
            <input type="text" :class="{ 'is-invalid' : errors.company }" class="form-control acc_format" id="company"  v-model="report.company" placeholder="Enter Company">
            <div v-if="errors.company" class="invalid-feedback">{{ errors.company[0] }}</div>
          </div>

          <!-- Attachments -->
          <div class="form-group">
          <label>Attachment</label>
          <div></div>
          <div class="custom-file">
          <input type="file" ref="attachment" @change="handleFileAttachment()" accept="image/*,application/pdf" :class="{ 'is-invalid' : errors.attachment }">
          <div v-if="errors.attachment" class="invalid-feedback">{{ errors.attachment[0] }}</div>
          </div>
          </div>
          
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" v-if="isForEdit === true" class="btn btn-primary" @click="update(report.id)">Update</button> 
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

        report: {
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
                $('#modalReport')
                .modal({
                    backdrop: "static",
                    keyboard: false
                });
            }
            else{
                $('#modalReport')
                .modal("hide");
            }
        }
        
    },

    methods: {
        close(){
            this.$emit('close', false);
            $('#modalReport').modal("hide");
            this.dowloading = false
        },

        store(){
            console.log('check if store is triggered')

            let formData = new FormData();
            let attachment = this.$refs['attachment']['files'][0];
            formData.append('attachment', attachment);
            if (this.report.title) formData.append('title', this.report.title);
            if (this.report.created_at) formData.append('created_at', this.report.created_at);
            if (this.report.detail) formData.append('detail', this.report.detail);
            if (this.report.department) formData.append('department', this.report.department);
            if (this.report.company) formData.append('company', this.report.company);

            axios.post(`/store-owner`,
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
        update(id){
          axios.patch(`api/reports/${id}`, {
                title: this.report.title,
                detail: this.report.detail,
                department: this.report.department,
                company: this.report.company,
                attachment: this.report.attachment,
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
                else if(error.response.status === 500){
                  alert('something went wrong');
                }
            })
        },
        handleFileAttachment(){
        this.attachment = this.$refs['attachment']['files'][0];
        },
    }
}
</script>
