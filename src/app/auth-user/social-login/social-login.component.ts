import { Component, OnInit } from '@angular/core';
import { ComingSoon } from 'src/app/common_fun';
import { UserService } from 'src/app/services/user.service';
import { AuthService } from 'src/app/services/auth.service';
import { Router } from '@angular/router';
declare var gapi: any;
declare var FB: any;

@Component({
  selector: 'app-social-login',
  templateUrl: './social-login.component.html',
  styleUrls: ['./social-login.component.css']
})
export class SocialLoginComponent implements OnInit {

  ComingSoon: any = ComingSoon


  constructor(
    private router: Router,
    public AuthService: AuthService,
    private userService: UserService,
  ) {

  }

  ngOnInit(): void {
    this.renderButton();
    this.fbAsyncInit();
  }

  renderButton() {
    gapi.signin2.render('gSignIn', {
      'scope': 'profile email',
      'width': 240,
      'height': 50,
      'longtitle': true,
      'theme': 'dark',
      'onsuccess': this.onSuccess,
      'onfailure': this.onFailure
    });
  }
  // Sign-in success callback
  onSuccess(googleUser: any) {
    // Get the Google profile data (basic)
    //var profile = googleUser.getBasicProfile();

    // Retrieve the Google account data
    gapi.client.load('oauth2', 'v2', () => {
      var request = gapi.client.oauth2.userinfo.get({
        'userId': 'me'
      });
      request.execute((resp: any) => {
        // Display the user details

        let userdata = {
          social_id: resp.id,
          email: resp.email,
          name: resp.name,
          loginType: 'Gmail'
        }
        console.log('google login success', resp)
        this.socialLogin(userdata);
      });
    });
  }

  socialLogin(data: any) {
    this.userService.socialLogin(data).subscribe((data: any) => {
      console.log('g login form', data);

      if (data.status == 1) {

        this.AuthService.authorization(data.data)

        this.router.navigate(['/dashboard']);
      } else {
        alert(data.message);
      }

    })
  }

  // Sign-in failure callback
  onFailure(error: any) {
    console.log('google login success', error)
  }

  // Sign out the user
  signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {

    });

    auth2.disconnect();
  }


  statusChangeCallback(response: any) {  // Called with the results from FB.getLoginStatus().
    console.log('statusChangeCallback');
    console.log(response);                   // The current login status of the person.
    if (response.status === 'connected') {   // Logged into your webpage and Facebook.
      this.testAPI();
    } else {                                 // Not logged into your webpage or we are unable to tell.
      console.log('102', response)
    }
  }


  checkLoginState() {               // Called when a person is finished with the Login Button.
    FB.getLoginStatus((response: any) => {   // See the onlogin handler
      this.statusChangeCallback(response);
    });
  }


  fbAsyncInit = () => {
    FB.init({
      appId: '1167445827384703',
      cookie: true,                     // Enable cookies to allow the server to access the session.
      xfbml: true,                     // Parse social plugins on this webpage.
      version: 'v3.2'           // Use this Graph API version for this call.
    });


    FB.getLoginStatus((response: any) => {   // Called after the JS SDK has been initialized.
      this.statusChangeCallback(response);        // Returns the login status.
    });
  };

  testAPI() {                      // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', (response: any) => {

      console.log('133', response);
      if (response.email) {
        // Display the user details
        let userdata = {
          social_id: response.id,
          email: response.first_name + ' ' + response.last_name,
          name: response.email,
          loginType: 'Facebook'
        }
        console.log('fb login success', response)
        this.socialLogin(userdata);
      } else {
        alert('Email not provided.');
      }

    });
  }



}
