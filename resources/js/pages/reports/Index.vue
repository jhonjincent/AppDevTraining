
<template>
<!-- eslint-disable vue/no-use-v-if-with-v-for,vue/no-confusing-v-for-v-if -->
<div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">La Filipina Uy Gongco Group of Companies
                <button type="button" @click="openModal()" class="btn btn-sm btn-outline-primary" style="float: right;">Add New Post</button>
        </div> 

        <table class="table">
            <tbody>
                <tr v-if="loading === false && reports" v-for="(report,i) in reports.data" :key="i">
                    <td>
                        <b>{{ report.title }}</b>
                        <p style="float: right;"><b>{{ report.department }}</b></p>
                        <p style="float: right;">-</p>
                            <p style="float: right;"><b>{{ report.company }}</b></p><br><br>
                    <div class="div2">
                        <p>{{ report.detail }}</p>
                        </div>
                        <a v-if="report.attachment" :href="'/storage/' + report.attachment.path" target="_blank">View Attachment</a><br><br>
                        <p><b>Comments</b></p>
                        <div class="div1">
                            <p>  
                                <span v-for="(comment,c) in report.comments" :key="c">
                               {{ comment.com }}<br>
                                </span>
                            </p>
                        </div>
                        <button @click="commentModal(report.id)" class="btn btn-secondary">Add Comment</button>
                    </td>
                    <td><b>{{ report.created_at }}</b></td>
                    <td>
                        <span v-if="report.owner"><b>{{ report.owner.postedbyinfo.name }}</b></span>
                    </td>
                    <td>
                        <button @click="deleteReport(i, report.id)" class="btn btn-danger" style="float: right;">Delete</button>
                        <button @click="modifyReport(report)" class="btn btn-primary" style="float: right;">Edit</button>
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
                    <button :disabled="reports.current_page == 1" @click="prevPage()" class="btn btn-primary btn-sm btn-fill"> Previous </button>
                        <span class="text-dark">Page {{ reports.current_page  }} of {{ reports.last_page }}</span>
                    <!-- <button :disabled="!showNextLink()" class="btn btn-default btn-sm btn-fill"> Next </button> -->
                    <button  @click="nextPage()" :disabled="reports.current_page == reports.last_page" class="btn btn-primary btn-sm btn-fill"> Next </button>
                </div>
                <div class="col-6 text-right">
                    <span>{{ reports.total }} Total</span>
                </div>
            </div>

            <!-- modal component -->
            <modal-report 
                :report="report" 
                :isForEdit="isForEdit"
                @resetEdit="isForEdit = $event"
                @returnReport="updateReport($event)"
                @return="pushNewReport($event)"
                @close="show = $event"
                :show="show">
            </modal-report> 

            <modal-comment 
                :reportId="reportId"
                :comment="comment" 
                @close="show_comment = $event"
                :show="show_comment">
            </modal-comment> 
            </div>
                </div>

</div>
</div>
</div>
</template>
<script>
import ModalReport from '../../components/ModalReport.vue';
import ModalComment from '../../components/ModalComment.vue';
export default{
    data(){
        return{
            show: false,
            show_comment: false,
            loading: false,
            reports: [],
            comments: [],
            search: "",
            current_page: 1,
            last_page_url: "",
            next_page_url: "",
            prev_page_url: "",
            isForEdit: false,
            report: {},
            comment: {},
            reportId: "",
            
        }
    },

    components: {
        ModalReport,
        ModalComment,
    },

    mounted() {
            console.log('Component mounted.')
            this.fetchReports();
            
        },

    methods: {
        openModal(){
            this.show = !this.show;
        },

        commentModal(Id){
             this.show_comment = !this.show_comment;
             this.reportId = Id;
            
         },


        pushNewReport(event){
            this.fetchReports();
        },

        fetchReports(){
            this.loading = true;
            axios.get('/api/reports')
            .then(response => {
                console.log('response: ', response.data)
                this.reports = response.data
                this.loading = false;
                
            })
        },

        deleteReport(index, id) {
                axios.delete(`/api/reports/${id}`)
                .then(response => {
                    if(response.status === 200 || response.status === 201) {
                        this.reports.data.splice(index,1);
                    }
                })
            }, 

            modifyReport(report) {
                this.show = !this.show;
                this.report = report;
                this.isForEdit = true;
            },

            updateReport(event) {
                let findReport = this.report.data.findIndex(x => x.id === event.id);
                this.report.data[findReport] = event;
            },

        prevPage() {
                this.loading = true
                axios.get(`${this.reports.prev_page_url}`)
                .then(response => {
                    this.reports = response.data;
                    this.loading = false;
                });
            },

            nextPage() {
                this.loading = true
                axios.get(`${this.reports.next_page_url}`)
                .then(response => {
                    console.log('check response ter: ', response)
                    this.reports = response.data
                    this.loading = false;
                });
            },
    },
    
}
</script>
<style>

div.container a
{
    margin: 0px 10px;
    padding: 10px 10px;
    position: relative;
    z-index: 0;
    cursor: pointer;
}

div.highlightTextOut a
{
    color: rgba(255, 255, 255, 0.3); 
}

div.highlightTextOut a:before, div.highlightTextIn a:before
{
    position: absolute;
    color: rgb(0, 0, 0);
    top: 0px;
    left: 0px;
    padding: 10px;
    overflow: hidden;
    content: attr(alt);
    transition: all 0.3s;
    transform: scale(0.8);
    opacity: 0;
} 

div.highlightTextOut a:hover:before, div.highlightTextIn a:hover:before
{
    transform: scale(1);
    opacity: 1;
}

/* Highlight text in  */
div.highlightTextIn a
{
    color: rgba(0, 0, 0, 0.4); 
}

div.highlightTextIn a:before
{
    transform: scale(1.2);
}

.div1 {
   background-color: rgb(255, 255, 255);
  width: 250px;
  border: 1px solid rgb(76, 117, 122);
  margin: 1px;
   border-radius: 25px;
   padding: 5px;
}

.div2 {
    background-color: rgb(255, 255, 255);
  width: 500px;
  border: 1px solid rgb(76, 117, 122);
  margin: 1px;
  border-radius: 25px;
  padding: 5px;
}

</style>




