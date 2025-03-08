<x-app-layout> 
    <style>
        .width-image-processed {
            width: -webkit-fill-available;
            height: -webkit-fill-available;
        }        

    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- <x-list-cards-banco /> --}}
        </div>
        <div class="max-w-7xl mx-auto flex">
            <div>
                <x-list-cards-banco />
            </div>
            <div class="w-full">
                @for ($key = 1; $key <= 3; $key++)
                    <x-box-link :key="$key" />
                @endfor
            </div>
        </div>
    </div> 
    <script type="text/javascript">
        function downloadImage(keyForm, isPreview) { 
    
            //Seleciona a div que contem as imagens para remover a imagem padrão pois será trocada pela imagem do preview
            let contentFile = document.getElementById("content-file-" + keyForm);
            contentFile.innerHTML = '';
            
            let gifMessage = document.getElementById("gif-message-" + keyForm); 
             
            //Selecionar o container do gif e exibir ele ao iniciar a busca pelo preview
            let previewContainer = document.getElementById("container-file-gif-" + keyForm);
            previewContainer.classList.remove('hidden');
               
            gifMessage.innerHTML = isPreview ? "Carregando Preview..." : "Baixando Imagem...";   
          
            //Inicia a requisição
            const xhttp = new XMLHttpRequest();
            
            //Define a rota 
            const actionUrl = @json(route('sendStock'));
            
            //Busca os dados do formulário
            let form = document.querySelector('#form-shutter-' + keyForm);
            let csrfToken = form.querySelector('input[name="_token"]').value;
            let inputUrl = form.querySelector('input[name="stock_url"]');
            let orderCode = form.querySelector('input[name="order_code"]');
            let btnForm = form.querySelector('button');
    
            //Desabilita o input e o botão após enviar a url
            inputUrl.disabled = true;
            inputUrl.classList.add("bg-gray-300","border-gray-300"); 
    
            btnForm.disabled = true;
            btnForm.classList.add("bg-gray-500","border-gray-500"); 
            
    
            let data = {
                stock_url : inputUrl.value, 
                isPreview : isPreview ? true : false, 
                orderCode : (orderCode != null) ?  orderCode.value : null
            }
    
            xhttp.open("POST", actionUrl, true);
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.setRequestHeader("X-CSRF-TOKEN", csrfToken);
    
            const dataToSend = JSON.stringify(data);
            xhttp.send(dataToSend);
    
            xhttp.onload = function() {
                console.log(this);
    
                let response;
    
                try {
                     response = JSON.parse(this.responseText);
                } catch (error) {
                    // Trata o erro de JSON inválido 
                    response = {
                        status : false,
                        message : "Resposta do servidor está inválida. Contacte o suporte!"
                    };
                } 
    
                let imageDefaultHTML = '<img class="w-[150px] h-[120px] rounded-lg" src="{{ asset('assets/images/image_blank.png') }}" alt="">';
                
                let imagePath = response.imagePath;
                let baseUrl = "{{ asset('storage/processed_image/') }}"; 
                let completeUrl = isPreview ? imagePath : baseUrl + '/' + imagePath;
    
                console.log(response);
                if (this.status == 200 && response.status == true){ 
    
                    let orderCodeSpan = document.getElementById('order-code-render-' + keyForm); 
                    console.log(orderCodeSpan);
                    let orderCodeInput = '<input type="hidden" id="order-code-' + keyForm + '" name="order_code" value="' + response.orderCode + '">';
                    let imagePreview = '<img class="width-image-processed" src="' + completeUrl + '" alt="" />'; 
                    
                    gifMessage.innerHTML = '';
                    previewContainer.classList.add('hidden');
                  
                    contentFile.innerHTML = imagePreview;
    
                    //Exibe o card de confirmar o download
                    if(isPreview){
                       //TODO: Melhorar a função, ao cancelar realizar a troca dos botões e dos textos
                       //mover esse script para a função cancelDonwlodAfterProcess / downloadFileProcessed
                       //iago: funções não foram criadas ainda por isso deixei as trocas de texto antes de abrir o modal do preview

                       //seleciona os botões de confirmação e os exibe
                        let buttonsCardDownload = document.getElementById('card-download-buttons-' +  keyForm);
                        let buttonFileCardDownload = document.getElementById('card-dowload-button-file-' +  keyForm); 
                        
                        buttonFileCardDownload.classList.add("hidden");
                        buttonsCardDownload.classList.remove("hidden");

                        //realiza a troca da mensagem de sucesso
                        let titleCardDownload = document.getElementById('card-download-title-' +  keyForm);
                        let textCardDownload = document.getElementById('card-download-text-' +  keyForm);
    
                        titleCardDownload.innerHTML = 'Deseja confirmar o pedido do arquivo?';
                        textCardDownload.innerHTML = 'Clique abaixo para confirmar.';   

                        let cardConfirmDownload = document.getElementById('container-card-download-' + keyForm);
                        cardConfirmDownload.classList.remove("hidden");

                        //insere o order code no input 
                        orderCodeSpan.innerHTML = orderCodeInput;
                    }else{
                        //realiza a troca do icone do card  de donwload com sucesso!
                        let iconCheckCardDownload = document.getElementById('card-download-icon-check-' + keyForm);
                        let iconDownCardDownload = document.getElementById('card-download-icon-down-' + keyForm); 
    
                        iconCheckCardDownload.classList.remove("hidden"); 
                        iconDownCardDownload.classList.add("hidden");
    
                        //realiza a troca da mensagem de sucesso
                        let titleCardDownload = document.getElementById('card-download-title-' +  keyForm);
                        let textCardDownload = document.getElementById('card-download-text-' +  keyForm);
    
                        titleCardDownload.innerHTML = 'Processamento Concluído!';
                        textCardDownload.innerHTML = 'Clique no botão abaixo para baixar a imagem para o seu computador.';
                        
                        //disponibiliza o botão de baixar imagem para o pc
                        let buttonsCardDownload = document.getElementById('card-download-buttons-' +  keyForm);
                        let buttonFileCardDownload = document.getElementById('card-dowload-button-file-' +  keyForm);
                        buttonFileCardDownload.setAttribute('href', completeUrl);
                        buttonFileCardDownload.setAttribute('download', imagePath);
                        
                        buttonsCardDownload.classList.add("hidden");
                        buttonFileCardDownload.classList.remove("hidden");

                        //remove o order code no input 
                        orderCodeSpan.innerHTML = '';
                        limitCounter();
                    }
                }else{
                    let responseError = response.message != null ? response.message : 'Erro de servidor';
                    // console.log("Erro:" + responseError);
    
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
            let form = document.querySelector('#form-shutter-' + keyForm); 
            let inputUrl = form.querySelector('input[name="stock_url"]');
            let btnForm = form.querySelector('button');
    
            let containerAlert = document.getElementById('container-box-alert-'+ keyForm);
            containerAlert.classList.add('hidden');        
    
            inputUrl.disabled = false;
            inputUrl.classList.remove("bg-gray-300","border-gray-300"); 
    
            btnForm.disabled = false;
            btnForm.classList.remove("bg-gray-500","border-gray-500"); 
        }
    
        function cancelDownload(keyForm){
    
            let form = document.querySelector('#form-shutter-' + keyForm); 
            let inputUrl = form.querySelector('input[name="stock_url"]');
            let btnForm = form.querySelector('button');

            let cardConfirmDownload = document.getElementById('container-card-download-' + keyForm);
            cardConfirmDownload.classList.add("hidden"); 
    
            inputUrl.disabled = false;
            inputUrl.classList.remove("bg-gray-300","border-gray-300"); 
    
            btnForm.disabled = false;
            btnForm.classList.remove("bg-gray-500","border-gray-500"); 
            inputUrl.value = "";
        }
    </script>
</x-app-layout>
