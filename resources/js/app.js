import axios from 'axios';
import './bootstrap';

var progress = 0;
const total = totalElems.innerText;
var totalRowsAddedDB = 120;
progress = getProgress(totalRowsAddedDB);


new Promise( function(resolve, reject) {
    resolve(axios.get('userID'))
})
.then( (value) => {
    
    let userID = value.data;
    const channel = Echo.private(`parsingProgressDB.user.${userID}`);
        
    channel
        .subscribed(() => {
            console.log('subscribed!!!');
            progressBarContainer.style.display = 'flex';
        });

    channel
        .listen('.newRowDB', (event) => {
            console.log(event);
            progress = getProgress(event.totalRowsAddedDB);
            if(progress === 100) {
                closeParsingInfo();
                return;
            }
            displayProgress(progress, event.totalRowsAddedDB)
        });
});

function getProgress(totalRowsAddedDB) {
    return Math.round( 100 * totalRowsAddedDB/total );   
}

function displayProgress(progress, totalRowsAddedDB) {
    progressElem.style.width = progress + '%';
    counterValue.innerText = progress + '%';
    totalElems.innerText = totalRowsAddedDB + ' / ' + total;
}

function closeParsingInfo(){
    progressBarContainer.style.display = 'none';
    displayProcess.style.display = 'none';
    displayFinished.style.display = 'block';
    totalElems.innerText = total + ' / ' + total;
}