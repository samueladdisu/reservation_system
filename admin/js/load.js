

let checkBoxArray = []

const app = Vue.createApp({
  data() {
    return {
      location: '',
      roomType: '',
      allData: '',
      bookedRooms: [],
      totalPrice: 0,
      selectAllRoom: false,
      singleRoom: false
    }
  },
  methods: {
    bookAll() {
      const checkBoxes = document.querySelectorAll('.checkBoxes')

      if (this.selectAllRoom) {
        this.bookedRooms = this.allData
        this.bookedRooms.forEach(row => {
          this.totalPrice += parseInt(row.room_price)
        })
      } else {
        this.bookedRooms = []

        this.totalPrice = 0

      }

      console.log(this.totalPrice);
    },
    booked(row) {
      var checkin = new Date(this.$refs.checkin.value);
      var checkout = new Date(this.$refs.checkout.value);
      // To calculate the time difference of two dates
      var Difference_In_Time = checkout.getTime() - checkin.getTime();
        
      // To calculate the no. of days between two dates
      var stayedNights = Difference_In_Time / (1000 * 3600 * 24);
      
      console.log(stayedNights)
      if (event.target.checked) {
        console.log(event.target);
        this.totalPrice += parseInt(row.room_price) * stayedNights
        this.bookedRooms.push(row)
      } else {
        this.totalPrice -= parseInt(row.room_price)
        let rowIndex = this.bookedRooms.indexOf(row)

        this.bookedRooms.splice(rowIndex, 1)

      }
      this.fetchAll()

      // console.log("total price",this.totalPrice);
      console.log("booked rooms", this.bookedRooms);
      console.log(this.allData);

    },
    filterRooms() {
      console.log(this.location);
      axios.post('load_modal.php', {
        action: 'filter',
        location: this.location,
        roomType: this.roomType
      }).then(res => {
        console.log(res.data);
        this.allData = res.data
      }).catch(err => console.log(err.message))
    },
    clearFilter() {
      this.fetchAll()
    },
    bookRooms() {
      const checkBoxes = document.querySelectorAll('.checkBoxes')
        
   
      checkBoxes.forEach(check => {

        if (check.checked) {
          checkBoxArray.push(check.value)

        } else {
          console.log('not');
        }

      })


      axios.post('load_modal.php', {
        action: 'update',
        data: checkBoxArray,
        price: this.totalPrice

      }).then(res => {
        console.log(this.bookedRooms);
        console.log("price", res.data);
      }).catch(err => console.log(err.message))

    },
    reserveRooms() {
      const checkBoxes = document.querySelectorAll('.checkBoxes')

      checkBoxes.forEach(check => {

        if (check.checked) {
          checkBoxArray.push(check.value)

          axios.post('load_modal.php', {
            action: 'reserve',
            data: checkBoxArray,
            price: this.totalPrice

          }).then(() => {

            console.log(this.bookedRooms);
          }).catch(err => console.log(err.message))
        } else {
          console.log('not');
        }

      })
    },
    fetchAll() {
      axios.post('load_modal.php', {
        action: 'fetchAll'
      }).then(res => {
        this.allData = res.data
        // console.log(this.allData);
      })
    }
  },
  created() {
    this.fetchAll()
  }
})

app.mount('#app')


window.addEventListener('load', () => {
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
      })

    } else {
      checkBoxes.forEach(check => {
        check.checked = false
      })
    }
  })

  location.addEventListener('click', function (e) {
    e.preventDefault()
    axios.post('load_modal.php', {
      action: 'filter',

    })

  })
  book.addEventListener('click', function (e) {

    e.preventDefault()
  })
})





