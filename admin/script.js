

const app = Vue.createApp({
	data(){
		return {
			query: '',
			search_data: []
		}
	},
	methods: {
		getData() {
			this.search_data = []
			axios.post('load_modal.php', {
				query: this.query,
				action: 'fetchPromo'
			}).then(res => {
				console.log(res.data);
				this.search_data = res.data
			});
		},
		getName(name){
			this.query = name 
			this.search_data = []
		}
	}
}).mount('#autocomplete_app')


