
const app = Vue.createApp({
  data() {
    return {
      allData: '',
      checkIn: '',
      checkOut: '',
      destination: '',
      actionBtn: 'insert'
    }
  },
  methods: {
    async fetchAllData() {

      try {
        const res = await axios.post('book.php', {
          action: 'fetchall'
        }).then(response =>{
          this.allData = response.data
        })

        
      } catch (error) {
        console.log(error);
      }
    
    },
    // submitData(){
    //   if(this.checkIn != '' && this.checkOut != '' && this.destination != ''){
    //     if(this.actionBtn == 'insert'){
    //       axios.post("book.php",{
    //         action: 'insert',
    //         checkIn: this.checkIn,
    //         checkOut: this.checkOut,
    //         destination: this.destination
    //       }).then(response => {
    //         this.fetchAllData()
    //       })
    //     }
    //   }else {
    //     alert("Fill All fields");
    //   }
    // }
  },
  created() {
    this.fetchAllData()
  }
})

app.mount('#app')

const register = Vue.createApp({
  data() {
    return {
      arrival: ""
    }
  },
  methods: {
    
  },
  watch: {
    arrival() {

    }
  }
})

register.mount("#regApp")