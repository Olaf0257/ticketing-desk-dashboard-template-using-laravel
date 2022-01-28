Vue.component('v-select', VueSelect.VueSelect)
        new Vue({
          el: '#app1',
          data: {
             reply_message: null,
             uuid: null
          },
            methods: {
                submitReply : function(){
                     let api_url = '/' + this.uuid + '/ticket_reply'
                      axios.post(api_url, {
                        reply: this.reply_message
                      }).then(response => {
                            window.location.reload();
                     })
                }
           },
            /*
            Initialize user's country and state for profile update.
             */
            mounted(){
                 this.uuid = uuid;
            }
        })
