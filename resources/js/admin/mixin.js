const mixin = {
  data: () => ({
    token: {
      csrf: null
    }
  }),
  computed: {
    csrf: {
      get() {
        this.csrf_token().then(res => {
          this.token.csrf = res.data.csrf_token
        });
        return this.token.csrf;
      }
    }
  },
  created() {
    // this.csrf_token();
  },
  methods: {
    async csrf_token() {
      return axios.get('http://localhost/laravel-woocommerce/csrf-token');
    },
    closeModal: function(){
      console.log("called")
      jQuery('.modal').modal('hide');
      jQuery('.modal-backdrop').remove();
    }
  }
};

export default mixin;