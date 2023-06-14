<div class="menu-header">
    <div class="container">
      <nav>
        <div class="main-logo">
          <a href="/"><img src="https://tripscon.com/assets/img/logo_black.webp" alt=""></a>
        </div>
        <ul class="main-menu">
          <!-- <li>
            <a class="custom-button" href="{{url('entry/submit/' . \App\Models\Contest::where('status', 'active')->first()->id)}}">
               
                Submit entry
            </a>
          </li> -->
          <li>
            <a  href="{{url('/rules')}}">

                Rules
            </a>
          </li>
          <li>
            <a  href="{{url('/')}}">
            <i class="fa-regular fa-image"></i>
                Gallery
            </a>
          </li>
          <!-- <li>
           <div class="form-wrapper">
           <i class="fa-solid fa-chevron-down"></i>
            <select name="" id="result-filter" class="form-control">
            
              <option value="most-voted">Most Voted</option>
              <option value="most-recent">Most Recent</option>
              <option value="oldest">Oldest</option>
            </select>
           </div>
          </li> -->
          @if(\Auth::check())
          <li>
            <a href="{{url('/logout')}}">
              logout</a>
          </li>
          @endif
        </ul>
      </nav>
    </div>
  </div>
