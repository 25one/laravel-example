@extends('dashboard.layout')

@section('css')

@endsection

@section('main')

            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3 class="page-header">Manual and API Settings</h3>
                            <br>

                            @if (! count(auth()->user()->keysActive))
                            @if (auth()->user()->demo_count)    
                            <p>
                            You have <strong class="text-success">{{auth()->user()->demo_count}}</strong> demo requests. After using them, you need to add an <strong>API KEY</strong> to the AI ​​model in your profile to continue working..
                            </p>
                            @else
                            <p>
                            You <strong class="text-danger">no longer</strong> have demo requests. You need to add an <strong>API KEY</strong> to the AI ​​model in your profile to continue working.  
                            </p>
                            @endif
                            @endif
                            <hr>

                            <p>
                                Your <strong>user API token</strong> (field api_token in request) is
                                <a href="#" id="test" class="form-control btn btn-link" title="click to copy to clipboard" onclick="event.preventDefault();" data-clipboard-text="{{Auth::user()->api_token}}">{{Auth::user()->api_token}}</a>
                            </p>
                            <br>

                            <h4>1.Prompts-Project-Dashboard</h4>

                            <p style="text-align: justify;">
                            <strong>List Projects</strong> - create your new project, add your first prompt to it, execute it - get a response from the AI ​​model.
                            <br>
                            You can add the next prompt to your project, creating a prompt chain. To use the result of the previous prompt, add the <strong>#beforeprompt#</strong> mask to the text of the next prompt.
                            Please note that prompts are executed in numerical order. If you don't want a project prompt to be executed at the moment, uncheck the <strong>"active"</strong> box.
                            <br>
                            This means you can pre-create prompts and test them before you use API access to them from your application.
                            </p>
                            <br>

                            <h4>2.API-access to your prompts</h4>

                            <p style="text-align: justify;">
                            Each prompt and project has its own API token (see in the execution window).
                            <br>
                            To access the AI-CRM Pilot API from your application, use the following parameters: 
                            <br><strong>URL:</strong> https://pilot.25one.com.ua/api/prompt-execute?api_token=xxxxxxx (where the <strong>api_token</strong> field is your <strong>user API token</strong> in the Pilot system (see the top of the page)), 
                            <br><strong>method</strong>: POST, 
                            <br><strong>request</strong> parameters:<br> 
                                            {<br>
                                                'type': <strong>'prompt'</strong>, //or <strong>'project'</strong><br>
                                                'token': 'xxxxx', //<strong>prompt/project API tokent</strong> (see in <strong>the execution window</strong>)<br>
                                                'prompt': '.....' //your text of prompt or null<br>
                                            }<br>

                            The prompt field in this request requires further explanation:
                            <br>-if you have generated the full prompt text via Dashboard and it <strong>does not need any addition</strong>, you can use its null value ('prompt': null). For example, in your Dashboard you created a prompt like "Tell me a story about summer in 30 words";
                            <br>-if you want <strong>to add some information</strong> from your application code to the prompt Dashboard, you can add the <strong>#apiprompt#</strong> mask to the prompt Dashboard text and send this addition from your application code to the prompt request field. For example, in your Dashboard you created a prompt like "Tell me a story about #apiprompt# in 30 words" and the prompt parameter in request 'prompt': 'winter' - your resulting prompt for the AI ​​model will be "Tell me a story about winter in 30 words". 
                            <br>

                            You can add your Dashboard prompt not only with a word (phrase), but also, for example, with <strong>JSON</strong>. For example, you have a prompt on your Dashboard:<br>
                            "Below is a list of clothing models in JSON format. Using the fields name (the name of the clothing model), material (the material from which this clothing model is made), and country (the country where this clothing model was made), make a short (up to 100 words) description of each clothing model (who it is intended for, where and with what to wear it, what positive characteristics it has, etc.) and return the same JSON, but add the description you made for each clothing model to the empty description field:<br>
                            <strong>#apiprompt#</strong><br>
                            Return only the finished JSON without any explanations"<br>
                            And from your code in the request parameter 'prompt': '[{"id": 3, "name": "Blouse Breeze", "material": "synthetics", "country": "China", "description": ""}, {"id": 4, "name": "Coat White Light", "material": "wool", "country": "Pakistan", "description": ""}, {"id": 6, "name": "Denim jacket Blue Cotton", "material": "cotton", "country": "Türkiye", "description: ""}]'
                            </p>
                            <br>

                            <h4>3.AI-сhat in your project</h4>

                            <p style="text-align: justify;">
                            On your project pages, you can connect and use AI chat, which will work (answer your clients' questions) with information about your company (your contacts, products, services, etc.) and will not require additional manual work from operators.

                            <br>To use the API chat on your project pages:
                            <br>-on the Dashboard page (<strong>Chat Description</strong>), add a detailed description of your company's activities (contacts, products, services, etc.). The AI ​​model will use this description to answer your customers' questions. This description should contain as much information as possible that might be of interest to chat users
                            <br>-add this code block anywhere on your project pages (for example, the layout):
                            <br><br>
                            <textarea style="field-sizing: content;">
                                <div id="divIframeJs" style="position: fixed; bottom: 0; right: 0; z-index: 9999; opacity: 0; border-radius: 5px;">
                                <i class="fa fa-close" style="position: absolute; bottom: 250; right: 0; font-size: 2em; cursor: pointer;" onClick="document.getElementById('chatLogo').style.display='block'; document.getElementById('divIframeJs').style.opacity=0;"></i>
                                <iframe id="iframeJs" name="iframeJs" src="https://pilot.25one.com.ua/public/widget-chat/chat.html?api_token=xxxxxxx" style="width: 350px; height: 250px;" frameborder="0" scrolling="no"></iframe>
                                </div>
                                <img id="chatLogo" style="position: fixed; bottom: 0; right: 0; width: 100px; height: 100px; z-index: 9999; display: 'block'; cursor: pointer;" src="https://pilot.25one.com.ua/public/img/chat.png" alt onClick="this.style.display='none'; document.getElementById('divIframeJs').style.opacity=1; document.getElementById('iframeJs').src=document.getElementById('iframeJs').src;" />
                            </textarea>

                            where the <strong>api_token</strong> field is your <strong>user API token</strong> in the Pilot system (see the top of the page)
                            </p>
                            <hr>
                            <p>If you have any questions, please contact me <strong>+380681072861</strong> (<strong>telegram</strong>, <strong>viber</strong>)</p>

                        </div>
                    </div>
                </div>
            </div>                    

@endsection

@section('js')
<script src="{{ asset('js/clipboard/dist/clipboard.min.js') }}"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.4/clipboard.min.js"></script> --> 
<script>
// Initialize clipboard.js on all elements with the class 'a.btn'
var clipboard = new ClipboardJS('a.btn');

// Optional: Add event listeners to provide user feedback
clipboard.on('success', function(e) {
    console.log('Copied text:', e.text);
    e.clearSelection(); // Deselects the text after copying
    // You could add a "Copied!" tooltip here
});

clipboard.on('error', function(e) {
    console.error('Action:', e.action);
    // Fallback: advise user to press Ctrl+C
});
</script>
@endsection
