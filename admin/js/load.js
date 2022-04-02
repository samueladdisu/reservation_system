


let checkBoxArray = []
let start, end;

$(document).ready(function () {

  const tdate = $('.t-datepicker')
  tdate.tDatePicker({
    show: true,
    iconDate: '<i class="fa fa-calendar"></i>'
  });
  tdate.tDatePicker('show')


  tdate.on('eventClickDay', function (e, dataDate) {

    var getDateInput = tdate.tDatePicker('getDateInputs')

    start = getDateInput[0];
    end = getDateInput[1];

    console.log("start", start);
    console.log("end", end);

  })
});



const app = Vue.createApp({
  data() {
    return {
      location: '',
      roomType: '',
      allData: '',
      bookedRooms: [],
      totalPrice: 0,
      rowId: [],
      selectAllRoom: false,
      singleRoom: false,
      stayedNights: 0,
      isPromoApplied: '',
      promoCode: '',
      oneClick: false,
      formData: {
        res_firstname: '',
        res_lastname: '',
        res_phone: '',
        res_email: '',
        res_guestNo: '',
        res_groupName: '',
        res_paymentMethod: '',
        res_paymentStatus: '',
        res_promo: '',
        res_specialRequest: '',
        res_remark: '',
        res_extraBed: false
      }
    }
  },
  mounted() {
    

  },
  methods: {
    fetchPromo() {
      this.oneClick = true

      // console.log("top promo", this.isPromoApplied);
      if (!localStorage.promoback) {
        console.log("excuted");
        axios.post('load_modal.php', {
          action: 'promoCode',
          data: this.formData.res_promo
        }).then(res => {
          let discount = this.totalPrice - ((res.data / 100) * this.totalPrice)

          this.totalPrice = discount
          // localStorage.totalBack = JSON.stringify(this.totalPrice)
          console.log(res.data);

        })
        this.isPromoApplied = true
        // localStorage.promoback = this.isPromoApplied
      }

      this.isPromoApplied = JSON.parse(localStorage.promoback || false)
    },
    async addReservation(){
      console.log("Room Ids",this.rowId);
      console.log("check in", start);
      console.log("check out", end);
      console.log("Form Data", this.formData);

      await axios.post('load_modal.php', {
        action: 'addReservation',
        Form: this.formData,
        checkin: start,
        checkout: end,
        roomIds: this.rowId,
        price: this.totalPrice
      }).then(res => {
        window.location.href = 'view_all_reservations.php'
        console.log(res.data);
      })

    },
    selectAll() {

      var checkin = new Date(start)
      var checkout = new Date(end)
  
      console.log(checkin);
      console.log(checkout);
      // To calculate the time difference of two dates
      var Difference_In_Time = checkout.getTime() - checkin.getTime();
  
      // To calculate the no. of days between two dates
       var stayedNights = Difference_In_Time / (1000 * 3600 * 24);

      if (!this.selectAllRoom) {
        console.log("all");
        for (data in this.allData) {
          this.rowId.push(parseInt(this.allData[data].room_id))
          this.bookedRooms = this.allData

        }
        this.bookedRooms.forEach(row => {
          this.totalPrice += parseInt(row.room_price) * stayedNights
        })


        console.log("booked rooms", this.bookedRooms);
        console.log("Total Price", this.totalPrice);
        console.log("row ids", this.rowId);


      } else {

        this.rowId = []
        this.bookedRooms = []
        this.totalPrice = 0
        console.log("booked rooms", this.bookedRooms);
        console.log("Total Price", this.totalPrice);
        console.log(this.rowId);
      }
    
    },
    booked(row) {
      var checkin = new Date(start)
      var checkout = new Date(end)

      // To calculate the time difference of two dates
      var Difference_In_Time = checkout.getTime() - checkin.getTime();
  
      // To calculate the no. of days between two dates
       var stayedNights = Difference_In_Time / (1000 * 3600 * 24);


      // console.log(stayedNights)
      if (event.target.checked) {
        console.log(event.target);
        console.log("check");
        this.totalPrice += parseInt(row.room_price) * stayedNights
        this.bookedRooms.push(row)
      } else {
        this.totalPrice -= parseInt(row.room_price) * stayedNights
        let rowIndex = this.bookedRooms.indexOf(row)

        this.bookedRooms.splice(rowIndex, 1)

      }

      // console.log("total price",this.totalPrice);
      console.log("booked rooms", this.bookedRooms);
      console.log(this.allData);

    },
   async filterRooms() {
      console.log(this.location);
     await axios.post('load_modal.php', {
        action: 'filter',
        location: this.location,
        roomType: this.roomType,
        checkin: start,
        checkout: end
      }).then(res => {
        console.log(res.data);
        this.allData = res.data
      }).catch(err => console.log(err.message))

      console.log("filtered data",this.allData);
    },
    clearFilter() {
      this.fetchAll()
      this.roomType = ''
      this.location = ''
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
    // $('.t-datepicker').tDatePicker({});
  }
})

app.mount('#app')



