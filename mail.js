document.getElementById('contact-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    const templateParams = {
        from_name: formData.get('name'),
        to_email: formData.get('email'),
        message: formData.get('message')
    };

    const serviceID = 'service_t9bp3pd'; 
    const templateID = 'template_onx4r3t';

    console.log('Form submission:', templateParams);
    emailjs.send(serviceID, templateID, templateParams)
    .then(function(response) {
        console.log('SUCCESS!', response.status, response.text);
        document.querySelector('.response').innerHTML = "Email successfully sent!";
    }, function(error) {
        console.error('FAILED...', error);
        document.querySelector('.response').innerHTML = `Email sending failed: ${error.text || 'Unknown error'}`;
    });

});