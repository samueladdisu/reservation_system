


// let user_location = document.querySelector('#user_location').value? document.querySelector('#user_location').value : ''

let user_location = document.querySelector('#user_location')
let location_value = ''
console.log(user_location);

const roomApp = Vue.createApp({
  data() {
    return {
      location: '',
      roomType: '',
      allData: '',
      bookedRooms: [],
      rowId: [],
      posts: [''],
      tempRow: {},
      page: 1,
      perPage: 9,
      pages: [],
      tempDelete: {}
    }
  },
  methods: {
    setTemp(row) {
      this.tempDelete = row
    },
    async deleteRes() {

      await axios.post('./includes/load_avialable_rooms.php', {
        action: 'delete',
        row: this.tempDelete
      }).then(res => {
        console.log(res.data);
        this.fetchAll()
      })
    },
    async filterRooms() {
      // console.log(this.location);

      if(user_location){
        location_value = user_location.value 
      }else{
        location_value = this.location
      }
      console.log(location_value);

      await axios.post('./includes/load_avialable_rooms.php', {
        action: 'filter',
        location: location_value,
        roomType: this.roomType,
        checkin: start,
        checkout: end
      }).then(res => {
        console.log(res.data);
        this.allData = res.data
      }).catch(err => console.log(err.message))

      console.log("filtered data", this.allData);
    },
    clearFilter() {
      this.fetchAll()
    },

    fetchAll() {
      axios.post('./includes/load_avialable_rooms.php', {
        action: 'fetchAllRoom'
      }).then(res => {
        this.allData = res.data
        console.log(this.allData);
      })
    },
    setPages() {
      let numberOfPages = Math.ceil(this.posts.length / this.perPage);
      for (let index = 1; index <= numberOfPages; index++) {
        this.pages.push(index);
      }
    },
    paginate(posts) {
      let page = this.page;
      let perPage = this.perPage;
      let from = (page * perPage) - perPage;
      let to = (page * perPage);
      return posts.slice(from, to);
    }
  },
  computed: {
    displayedPosts() {
      return this.paginate(this.posts);
    }
  },
  watch: {
    posts() {
      this.setPages();
    }
  },
  created() {
    this.fetchAll()
  }
})

roomApp.mount('#viewRoom')


let strongPassword = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})')
let mediumPassword = new RegExp('((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))')


const userForm = Vue.createApp({
  data() {
    return {
      fname: '',
      lname: '',
      uname: '',
      upwd: '',
      ucpwd: '',
      msg: [],
      button: true
    }
  },
  watch: {
    upwd(value){
      this.upwd = value
      this.validatePassword(value)
    },
    fname(value){
      this.fname = value 
      this.validateName(value)
    },
    lname(value){
      this.lname = value 
      this.validatelName(value)
    },
    uname(value){
      this.uname = value
      this.validateUname(value)
    },
    ucpwd(value){
      this.ucpwd = value
      this.checkPassword(value)

      
    }
  },
  methods: {
    buttonToggle(){
      if(this.msg.length == 0){
        this.button = true
      }
    },
    validatePassword(value){
      if(strongPassword.test(value)){
        this.msg['password'] = 'Strong'
      }else if(mediumPassword.test(value)){
        this.msg['password'] = 'Medium'
      }else{
        this.msg['password'] = 'Weak'
      }
    },
    checkPassword(value){
      if(this.ucpwd !== this.upwd){
        this.msg['cperr'] = 'Password doesn\'t match'
      }else{
        this.msg['cperr'] = ''
        if(this.msg.length == 0){
          this.button = !this.button
        }
      }

    },
    validateUname(value){
      if(/^[A-Za-z]+$/.test(value)){
        this.msg['uname'] = ''
      }else{
        this.msg['uname'] = 'User Name must be only Characters'
      }

      if(value.length >= 3){
        this.msg['Luname'] = ''
      }else{
        this.msg['Luname'] = 'User Name must be atleast 3 characters'
      }

    },
    validateName(value){
      
      if(/^[A-Za-z]+$/.test(value)){
        this.msg['fname'] = ''
      }else{
        this.msg['fname'] = 'Name must be only Characters'
      }

    },
    validatelName(value){
      
      if(/^[A-Za-z]+$/.test(value)){
        this.msg['lname'] = ''
      }else{
        this.msg['lname'] = 'Name must be only Characters'
      }

    },
    
  }
})

userForm.mount('#userForm')

const roomFrom = Vue.createApp({
  data() {
    return {
      tempAmt: '',
      amt: []

    }
  },
  methods: {
    addAmt(e){
      if(e.key === ',' && this.tempAmt){
        if (!this.amt.includes(this.tempAmt)){
          this.amt.push(this.tempAmt)

          axios.post('./includes/load_avialable_rooms.php',{
            action: 'amt',
            data: this.amt
          }).then(res =>{
            console.log(res.data);
          })
        }
        this.tempAmt = ''
      }
    },
    deleteAmt(am){
      this.amt = this.amt.filter(item => {
        return am !== item
      })
      axios.post('./includes/load_avialable_rooms.php',{
        action: 'amt',
        data: this.amt
      }).then(res =>{
        console.log(res.data);
      })
    }
  }
}).mount('#addRoom')