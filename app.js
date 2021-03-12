let form = document.querySelector('form');

form.addEventListener('submit', (event) => {
    event.preventDefault();
    //writeMessage();
})

function getMessages() {

    fetch('handler.php')
        .then(response => {
            response.json().then(json => {
                const html = json.reverse().map(function(message){
                    return `
                      <div class="message">
                        <span class="date">${message.created_at.substring(11, 16)}</span>
                        <span class="author">${message.author}</span> : 
                        <span class="content">${message.content}</span>
                      </div>
                    `
                  }).join('');
                let messages_block = document.querySelector("body > section > div.messages_block");
                messages_block.innerHTML = html;
            })

        })

}

