<style>
    #progressBarContainer{
        width: 50%;
        display:none;
        margin-top: 20px;
    }
    #progessBar{
        heigth: 30px;
        width: 100%;
        border: 5px solid blue;
    }
    #progressElem{
        height:100%;
        background: green;
    }
    #counterValue{
        heigth: 30px;
        width:50px;
        margin-left:10px;
        padding: 5px;
        display:flex;
        font-size:20px;
        color: red;
        font-weight:bolder;
        justify-content: center;
        align-items: center;
    }

</style>

<div id="progressBarContainer">
    <div id="progessBar">
        <div id="progressElem" style="width:00%"></div>
    </div>
    <div id="counter">
        <span id="counterValue">0%</span>
    </div>
</div>