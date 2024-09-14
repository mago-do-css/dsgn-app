<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shutterstock') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto">
        @for ($key = 1; $key <= 3; $key++)
            <x-box-link :key="$key" />
        @endfor
    </div>
    {{-- <img src="{{asset('storage/processed_image/car-3d-ia.jpg')}}" alt="" /> --}}
    {{-- <img class="h-auto w-full flex " src="{{ asset('assets/images/3d-car-preview.png') }}" alt=""> --}}
</x-app-layout>
<script type="text/javascript">
    function downloadImage(keyForm, isPreview) { 

        //seleciona a div que contem as imagens para remover a imagem padrão pois será trocada pela imagem do preview
        let contentFile = document.getElementById("content-file-"+keyForm);
        contentFile.innerHTML = '';
        
        let gifMessage = document.getElementById("gif-message-"+keyForm); 
         
        //selecionar o container do gif e exibir ele ao iniciar a busca pelo preview
        let previewContainer = document.getElementById("container-file-gif-"+keyForm);
        previewContainer.classList.remove('hidden');
           
        gifMessage.innerHTML = isPreview ? "Carregando Preview..." : "Baixando Imagem...";   
      
        //inicia a requisição
        const xhttp = new XMLHttpRequest();
        
        //define a rota 
        const actionUrl = @json(route('sendShutter'));
        
        let form = document.querySelector('#form-shutter-' + keyForm);
        let csrfToken = form.querySelector('input[name="_token"]').value;
        let inputUrl = document.querySelector('input[name="stock_url"]').value;
        console.log(inputUrl);

        let data = {
            stock_url : inputUrl,
            isPreview : isPreview ? true : false
        }

        xhttp.open("POST", actionUrl, true);
        xhttp.setRequestHeader("Content-Type", "application/json");
        xhttp.setRequestHeader("X-CSRF-TOKEN", csrfToken);

        const dataToSend = JSON.stringify(data);
        xhttp.send(dataToSend);

        xhttp.onload = function() {
            console.log(this);
            const response = JSON.parse(this.responseText); 
            let imageDefaultHTML = '<img class="h-auto max-w-sm rounded-lg" src="{{ asset('assets/images/image.jpg') }}" alt="">';

            if (this.status == 200 && response.status == true){
                console.log(response);

                let imagePreview = '<img class="h-auto w-full flex " src="{{ asset('assets/images/3d-car-preview.png') }}" alt="">';
                let imageProcessed = '<img src="{{asset('storage/processed_image/car-3d-ia.jpg')}}" alt="" />';
                
                gifMessage.innerHTML = '';
                previewContainer.classList.add('hidden');
            
                if(this.stepDownload == 'preview'){
                    contentFile.innerHTML = imagePreview;
                }else{
                    contentFile.innerHTML = imageProcessed;
                }
            
            }else{
                let responseError = response.message != null ? response.message : 'Erro de servidor';
                console.log("Erro:" + responseError);

                let alertMessage = document.getElementById('box-alert-message-'+keyForm);
                alertMessage.innerHTML = responseError;
                
                let containerAlert = document.getElementById('container-box-alert-'+ keyForm);
                containerAlert.classList.remove('hidden');

                previewContainer.classList.add('hidden');
                contentFile.innerHTML = imageDefaultHTML;
            }
        }

        xhttp.onerror = function() {
            console.error('Erro:'+ this.message);
        };
    }
</script>
<script>
   function closeAlert(keyForm){
        let containerAlert = document.getElementById('container-box-alert-'+ keyForm);
        containerAlert.classList.add('hidden');        
    }
</script>