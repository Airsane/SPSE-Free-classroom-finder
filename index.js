const request = require('request');
const fs = require('fs');
const classRoom = ["B101", "B102", "B103", "B104", "B125", "B130", "B133", "B201", "B202", "B203", "B204", "B206", "B221", "B224", "B301", "B302", "B303", "B304", "B305", "B306", "B321", "B322", "B323", "B330", "B332", "B333", "D152", "D251", "D252", "D351"];


const testData = JSON.parse('{"cmd":"get","data":{"id":"B101","date":1579002603648}}');
const finalData = {};

async function start() {
    classRoom.forEach((clasE,i)=>{
    setTimeout(async()=>{
            console.log(Math.floor(i/(classRoom.length-1)*100));
            console.log(clasE);
            await getClassRoomSchedule(clasE);
            setTimeout(()=>{
                fs.writeFileSync('data.json',JSON.stringify(finalData));
            },1000)
        },200*i)
    })
}

async function getClassRoomSchedule(classroom) {
    const data = JSON.parse('{"cmd":"get","data":{"id":"' + classroom + '","date":1579002603648}}');
    request.post('https://rozvrh.spse.cz/index.php', { json: data }, (err, response, body) => {
        if (err) {
            console.error(err)
            return
        }
        let d = {};
        for (let j = 0; j < 5; j++) {
            let arr = {};
            for (let i = 0; i <= 10; i++) {
                if (body.items == undefined || body.items[j] == undefined||body.items[j][i.toString()] == undefined) {
                    continue;
                }
                else {
                    body.items[j][i.toString()].forEach(hodina => {
                        arr[i] = hodina
                    });
                }
                d[j] = arr;
            }
            finalData[classroom] = d;
        }
    });
}


start();