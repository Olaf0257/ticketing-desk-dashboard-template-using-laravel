Vue.component('v-select', VueSelect.VueSelect)
        new Vue({
          el: '#app1',
          data: {
             reply_message: '',
             uuid: null,
             canned_responses: [],
             selected_canned_response: null,
             files: '',
             display_error: false,
             error_message: null,
             replying: false
          },
            methods: {
                submitReply : function(event){
                     event.preventDefault();
                     this.replying = true;
                     this.display_error = false;
                     this.error_message = null;
                     let formData = new FormData();
                     for( var i = 0; i < this.files.length; i++ ){
                        let file = this.files[i];
                        formData.append('attachments[' + i + ']', file);
                     }
                     formData.append('reply', this.reply_message);
                      axios.post(api_url, formData,
                      {
                        headers: {
                          'Content-Type': 'multipart/form-data'
                        }
                      })
                     .then(response => {
                            window.location.href = window.location.href;
                     })
                     .catch((error) => {
                        this.display_error = true;
                        this.replying = false;
                        this.error_message = error.response.data.error;
                    })
                },
                chooseMe: function(){
                    this.reply_message = this.selected_canned_response;
                },
                handleFileUploads: function(){
                    this.files = this.$refs.files.files;
                },
           },
            /*
            Initialize user's country and state for profile update.
             */
            mounted(){
                 axios.get(canned_api_url).then(response => {
                       this.canned_responses = response.data;
                })

            }
        })
