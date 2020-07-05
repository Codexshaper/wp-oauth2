<template>
    <div class="container">
        <div class="row justify-content-center">
            <div 
                class="modal fade" 
                id="createTableModal" 
                tabindex="-1" 
                role="dialog" 
                aria-labelledby="createTableModal"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                          <h4 class="modal-title font-weight-bold">Create Client</h4>
                          <button type="button" style="color:#fff" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                        <table class="form-table" role="presentation">

                            <tbody>
                                <tr>
                                    <th scope="row"><label for="name">App Name</label></th>
                                    <td><input type="text" class="regular-text" id="name" v-model="client.name" placeholder="ex: CodexShaper"></td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="redirect">Redirect URL</label></th>
                                    <td><input type="text" class="regular-text" id="redirect" v-model="client.redirect" placeholder="http://localhost"></td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="scope">Scopes</label></th>
                                    <td><input type="text" class="regular-text" id="scopes" v-model="client.scopes" placeholder="Comma separated ex: create,edit,delete"></td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="type">Type</label></th>
                                    <td>
                                        <select v-model="client.type" id="type">
                                            <option value="authorization_code">Authorization Code</option>
                                            <option value="password">Password</option>
                                            <option value="personal_access">Personal access</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="submit">
                                    <td class="text-left">
                                        <input type="button" name="submit" id="submit" class="btn btn-success" :value="(action == 'create') ? 'Create' : 'Update'" @click.prevent="(action == 'create') ? create() : update()">
                                    </td>
                                    <td class="text-right"><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></td>
                                </tr>
                            </tbody>
                        </table>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            action: String,
            client: Object,
            create: Function,
            update: Function
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
