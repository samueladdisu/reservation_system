

let checkBoxArray = []
 
const app = Vue.createApp({
  data(){
    return {
      location: '',
      allData: '',
      bookedRooms: [],
      selectAllRoom: false,
    }
  }, 
  methods: {
    bookAll(){
      const checkBoxes = document.querySelectorAll('.checkBoxes')

      if(this.selectAllRoom){
        checkBoxes.forEach(check =>{
          check.checked = true
        })
      }else{
        checkBoxes.forEach(check =>{
          check.checked = false
        })
      }
      if(this.selectAllRoom){
        this.bookedRooms = this.allData
        console.log(this.bookedRooms);
      }else{
        this.bookedRooms = []
        console.log(this.bookedRooms);
      }
    },
    booked(row){
      this.bookedRooms.push(row)
      console.log(this.bookedRooms);
     
    },
    filterRooms(){
      console.log(this.location);
      axios.post('load_modal.php', {
        action: 'filter',
        data: this.location
      }).then(res => {
        console.log(res.data);
        this.allData = res.data
      }).catch(err => console.log(err.message))
    },
    bookRooms(){
      const checkBoxes = document.querySelectorAll('.checkBoxes')
     
      checkBoxes.forEach(check => {
      
        if(check.checked){
          checkBoxArray.push(check.value)
  
          axios.post('load_modal.php', {
            action: 'update',
            data: checkBoxArray,
            
            
          }).then(() =>{
           
            console.log(this.bookedRooms);
          }).catch(err => console.log(err.message))
        }else{
          console.log('not');
        }
 
    })
    this.fetchAll()
    },
    reservation(){

    },
    fetchAll(){
      axios.post('load_modal.php',{
        action: 'fetchAll'
      }).then(res =>{
        this.allData = res.data
        console.log(this.allData);
      })
    }
  },
  created(){
    this.fetchAll()
  }
})

app.mount('#app')


window.addEventListener('load', () =>{
  // getData()
  const book = document.querySelector('#book')
  const location = document.querySelector('#location')
  const checkBoxes = document.querySelectorAll('.checkBoxes')
  const selectAllBoxes = document.querySelector('#selectAllboxes')
  selectAllBoxes.addEventListener('click', function () {
    if (this.checked) {
      console.log("all");
      checkBoxes.forEach(check => {
        check.checked = true
        console.log(check.value);
      })
    } else {
      checkBoxes.forEach(check => {
        check.checked = false
        console.log(check.value);
      })
    }
  })

  location.addEventListener('click', function(e){
    e.preventDefault()
    axios.post('load_modal.php', {
      action: 'filter',

    })

  })
  book.addEventListener('click', function(e){
    
    e.preventDefault()
   
    
  })


  
})


   


// function getData(){
//   $.ajax({
//     type: "GET",
//     url: "./includes/load_avialable_rooms.php",
//     data: '',
//     beforeSend: function() {

//     },
//     complete: function() {

//     },
//     success: function(data) {
//       $(".insert-data").html(data);
//       $(".checkBoxes")
//     }
//   })
// }
