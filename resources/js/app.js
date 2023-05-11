import './bootstrap';


//const channel = Echo.channel(`public.test.chanel`);

const channel = Echo.private(`parsingProgressDB.user.1`);
    
channel
    .subscribed(() => {
        console.log('subscribed!!!');
    });


channel
    .listen('.newRowDB', (event) => {
        console.log(event);
    });

