function downloadImage(keyForm, isPreview, actionUrl) {   
    //define o endpoint
    let actionUrl = 'http://localhost:8080/sending/stock';

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
    
    //Busca os dados do formulário
    let form = document.querySelector('#form-shutter-' + keyForm);

    let csrfToken = form.querySelector('input[name="_token"]').value;
    let inputUrl = form.querySelector('input[name="stock_url"]');
    let btnForm = form.querySelector('button');

    //Desabilita o input e o botão após enviar a url
    inputUrl.disabled = true;
    inputUrl.classList.add("bg-gray-300","border-gray-300"); 

    btnForm.disabled = true;
    btnForm.classList.add("bg-gray-500","border-gray-500"); 
    

    let data = {
        stock_url : inputUrl.value,
        //TODO: PASSAR O CODE_IB DINAMICO
        code_IB: 1,
        isPreview : isPreview ? true : false,
        
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

        let imageDefaultHTML = '<img class="h-auto max-w-sm rounded-lg" src="{{ asset(' + 'assets/images/image.jpg' + ') }}" alt="">';
        
        let imagePath = response.imagePath;
        let baseUrl = "{{ asset('storage/processed_image/') }}"; 
        let completeUrl = isPreview ? imagePath : baseUrl + '/' + imagePath;

        if (this.status == 200 && response.status == true){
            console.log(imagePath);

            //TODOS: ESTILIZAR A IMAGEM RETORNADA:  class="h-auto w-full flex"  
            let imagePreview = '<img src="' + completeUrl + '" alt="" />'; 
            
            gifMessage.innerHTML = '';
            previewContainer.classList.add('hidden');
          
            contentFile.innerHTML = imagePreview;

            //Exibe o card de confirmar o download
            if(isPreview){
                let cardConfirmDownload = document.getElementById('container-card-download-' + keyForm);
                cardConfirmDownload.classList.remove("hidden");
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
                
                buttonsCardDownload.classList.add("hidden");
                buttonFileCardDownload.classList.remove("hidden");
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
} 