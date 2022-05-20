

export function getDate(){
    var today:any = new Date();
    var dd:any = today.getDate();
    var mm:any = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
    var yyyy:any = today.getFullYear();
    if(dd<10){
      dd = '0'+dd
    } 
    if(mm<10){
      mm='0'+mm
    }
    
    return today = yyyy+'-'+mm+'-'+dd;
}

export function ComingSoon(){
  alert('Coming Soon!')
  return false;
}
export function convertJSONToFormData(params: any) {
  let n = new FormData();
  for (let key in params) {
    n.append(key, params[key])
  }
  return n;
}

export function AlertMessage(message:string){
  alert(message)
  return false;
}