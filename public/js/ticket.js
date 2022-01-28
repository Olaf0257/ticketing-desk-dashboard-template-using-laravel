Vue.component('ticket-tags', VueSelect.VueSelect)
new Vue({
  el: '#app1',
  data: {
     reply_message: null,
     uuid: null,
     tags:[],
     selected_tags: null
  },
    methods: {
        chooseMe() {
            this.$refs.tag_ref.value =  this.selected_tags;
        },
   },

    mounted(){
         this.uuid = uuid;
         if(current_tags) {
            this.selected_tags = JSON.parse(current_tags);
            this.$refs.tag_ref.value =  this.selected_tags;
         }

         let api_url = '/get_tags_api';
         axios.get(api_url).then(response => {
            this.tags = response.data;
        })
    }
})
