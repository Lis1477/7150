@if(Session::has('note'))

	<div class="popup-note js-popup-note">
	    
	    <div class="popup-note_background js-popup-note-background"></div>

	    <div class="popup-note_info-block">

	        <div class="close-button js-popup-close-button">✕</div>

	        <div class="text"><pre>{{ Session::get('note') }}</pre></div>

	    </div>


	</div>

@endif
