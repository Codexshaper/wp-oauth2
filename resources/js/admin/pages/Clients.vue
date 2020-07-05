<template>
  <div class="app-settings">
	<a 
	    href="#" 
	    class="btn btn-success" 
	    @click.prevent="reset"
	    data-toggle="modal" 
	    data-target="#createTableModal"> <i class="fas fa-plus"></i>Create new client</a>

	<div class="clients">
		<div 
		  v-for="(client, index) in clients" 
		  :key="index" 
		  class="dd-item" 
		  :data-index="index">
		    <div class="btn btn-info btn-block mt-3 d-flex" > 
		        <a href="#" @click.prevent class="btn btn-link text-white text-left flex-grow-1">{{ client.name }}</a>
		        <a href="#"  
		        class="btn btn-link text-white" 
		        data-toggle="collapse" 
		        :href="'#collapse_'+index+1" 
		        title="edit">Show</a>
		        <a 
			    href="#" 
			    class="btn btn-link text-white" 
			    @click.prevent="edit(client)"
			    data-toggle="modal" 
			    data-target="#createTableModal">Edit</a>
		        <a href="#" class="btn btn-link text-white text-right" @click.prevent="removeClient(client)">Remove</a>
		    </div>
		   <!-- ================== collapse  Start ================== -->
		    <div class="collapse" :id="'collapse_'+index+1">
		        <div class="card card-body">
		        	<p><span>App Name</span> : <span>{{ client.name }}</span></p>
		        	<p><span>Client ID</span> : <span>{{ client.id }}</span></p>
		        	<p><span>Client Secret</span> : <span>{{ client.secret }}</span></p>
		        	<p><span>Redurect URL</span> : <span>{{ client.redirect }}</span></p>
		        </div>
		      </div>
		      <!-- ================== collapse  Start ================== -->
		</div>
	</div>

	<client-modals :action="action" :client="client" :create="create" :update="update" />

  </div>
</template>

<script>
	import ClientModals from '../components/Modals/ClientModals.vue'
export default {
  name: 'Clients',
  components: {
  	ClientModals
  },
  data () {
    return {
    	action: 'create',
    	clients: [],
    	client: {
    		name: '',
    		redirect: '',
    		scopes: '',
    		type: 'password'
    	}
    };
  },
  mounted() {
  	this.fetchClients();
  },
  methods: {
  	fetchClients: function() {
  		axios.get("/oauth/clients")
  		.then(res => {
  			this.clients = res.data.clients
  		})
  		// .catch(err => console.log(err.response))
  	},
  	reset: function() {
  		this.action = 'create'
  		this.client = {
    		name: '',
    		redirect: '',
    		scopes: '',
    		type: 'password'
    	}
  	},
  	create: function() {
  		axios.post("/oauth/clients", this.client)
  		.then(res => {
  			this.clients = res.data.clients
  			this.closeModal()
        toastr.success("Client added successfully.");
  		})
  		.catch(err => {
        toastr.error(err.response.data);
      })
  	},
  	edit: function(client) {

  		this.action = 'edit'
  		let type = ''
  		if(client.password_client == true) {
  			type = 'password'
  		}else if(client.personal_access_client == true) {
  			type = 'personal_access'
  		} else if(client.authorization_code_client == true) {
  			type = 'authorization_code'
  		}

  		this.client = {
  			id: client.id,
  			name: client.name,
  			redirect: client.redirect,
  			scopes: client.scopes.toString(),
  			type: type
  		}
  	},
  	update: function() {
  		axios.put("/oauth/clients", this.client)
  		.then(res => {
  			this.clients = res.data.clients
  			this.closeModal()
        toastr.success("Client updated successfully.");
  		})
  		.catch(err => {
        toastr.error(err.response.data);
      })
  	},
  	removeClient: function(client) {
  		Swal.fire({
	        title: 'Are you sure?',
	        text: 'You will not be able to recover this Client again',
	        type: 'warning',
	        showCancelButton: true,
	        confirmButtonText: 'Yes, delete it!',
	        cancelButtonText: 'No, keep it'
	    }).then((result) => {
	        if (result.value) {
	        	let data = {
	        		id: client.id
	        	}
	           axios.delete("/oauth/clients", {params: data})
	           .then(res => {
	           	this.clients = res.data.clients
              toastr.success("Client removed successfully.");
	           })
	          .catch(err => {
              toastr.error(err.response.data);
            })
	        } else if (result.dismiss === Swal.DismissReason.cancel) {
	            Swal.fire(
	                'Cancelled',
	                'Your imaginary file is safe :)',
	                'error'
	            )
	        }
	    });
  	},
    closeModal: function(){
        window.$('.modal').modal('hide');
        window.$('.modal-backdrop').remove();
    },
  }
};
</script>

<style lang="css" scoped>
	.card-body {
		max-width: 100%;
	}
  .btn-edit {
    color: green;
  }
  .btn-delete {
    color: red;
  }
</style>
