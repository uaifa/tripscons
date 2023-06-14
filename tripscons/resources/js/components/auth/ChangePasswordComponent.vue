<template>
  <main>
    <div
      class="modal fade"
      id="changepassword"
      tabindex="-1"
      role="dialog"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
           <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
            
           > <span aria-hidden="true">×</span></button>
          <div class="modal-body">
            <div class="checkout-form mt-4">
              <div class="payment-title">
                <h2>Change Password</h2>
                <div id="errorMessage" style="color: red">{{ message }}</div>
              </div>
              <form>
                <div class="form-group mt-4">
                  <input
                    type="password"
                    class="form-control input_field"
                    placeholder="Old Password"
                    v-model="old_password"
                  />
                </div>
                <div class="form-group mt-4">
                  <input
                    type="password"
                    class="form-control input_field"
                    placeholder="Change Password"
                    v-model="password"
                  />
                </div>
                <div class="form-group mt-4">
                  <input
                    type="password"
                    class="form-control input_field"
                    placeholder="Re-type Password"
                    v-model="confirm_password"
                  />
                </div>
                <div class="d-flex justify-content-end mt-4">
                  <button class="btn btn-whitee" @click="changePassword">
                    Change
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
//import $ from "jquery";
export default {
  name: "ChangePasswordComponent",
  data() {
    return {
      old_password: "",
      password: "",
      confirm_password: "",
      message: "",
    };
  },
  created() {},
  methods: {
    closeModal() {
      //$("#changepassword").hide();
      $("#changepassword").modal('hide');
      // $("#changepassword").modal('hide');
      //$("#changepasswordclose").click();
      //$("#changepasswordclose .close").click();
    },
    changePassword(e) {
      e.preventDefault();
      if (this.old_password == "") {
        this.message = "Please enter old password";
        return;
      }
      if (this.password == "") {
        this.message = "Please enter password";
        return;
      }
       if(this.confirm_password == "") {
        this.message = "Please enter conform password";
        return;
      }
      
      if (this.password == this.confirm_password) {
        let bodyFormData = new FormData();
        bodyFormData.append("password", this.password);
        bodyFormData.append("confirm_password", this.confirm_password);
        bodyFormData.append("old_password", this.old_password);
        axios.post("/api/changePassword", bodyFormData).then((response) => {
          if (response.status == 200) {
             this.$swal({
            type: "success",
            title: "Success!",
            text: response.data.message,
            timer: 2500,
          });
          this.password ='';
          this.confirm_password='';
          this.old_password='';
          this.message ='';
          this.closeModal();
          }
          }).catch((err) => {
          this.message = err.response.data.message;
          });
      }else {
        this.message = "Passwords should be match.";
        return false;
      }
    },
  },
};
</script>

<style scoped>
</style>
