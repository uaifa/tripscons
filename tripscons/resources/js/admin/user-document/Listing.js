import AppListing from '../app-components/Listing/AppListing';

Vue.component('user-document-listing', {
    mixins: [AppListing],
    toggleSwitch: function toggleSwitch(url, col, row) {
        var _this8 = this;

        axios.post(url, row).then(function (response) {
            _this8.$notify({ type: 'success', title: 'Success!', text: response.data.message ? response.data.message : 'User Profile Approved.' });
        }, function (error) {
            row[col] = !row[col];
            _this8.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });
        });
    },
});
