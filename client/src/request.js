
class Request
{
    makeRequest(url, options = {}){
        return fetch(url, options).then(response => {
            if(response.status === 200){
                return response.json();
            }
    
            return response.text().then(text => {
                throw new Error(text);
            });
        });
    }
}

export default Request;