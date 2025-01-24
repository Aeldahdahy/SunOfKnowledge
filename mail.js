document.getElementById('contact-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    const templateParams = {
        name: formData.get('name'),
        email: formData.get('email'),
        message: formData.get('message')
    };

    const serviceID = 'service_l1db3ba'; 
    const templateID = 'template_z8hucij';

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