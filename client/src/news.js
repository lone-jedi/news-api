class NewsApi
{
    constructor(domain, token = "") {
        console.log(domain);
        this.domain = domain;
        this.token  = token;
        console.log(this.domain);
    }

    makeRequest (url, options = {}) {
        return fetch(url, options).then(response => {
            if(response.status === 200){
                return response.json();
            }
    
            return response.text().then(text => {
                throw new Error(text);
            });
        });
    }

    makeFormData(data) {
        const formData = new FormData();
        for(let key in data) {
            formData.append(key, data[key]);
        }
        return formData;
    }

    getAll() {
        return this.makeRequest(this.domain + "all")
                .then(console.log);
    }

    get(id) {
        return this.makeRequest(this.domain + `one/${id}`)
                .then(console.log)
    }

    delete(id) {
        return this.makeRequest(this.domain + `delete/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(console.log)
    }

    add(title, content) {
        let data = this.makeFormData({title, content});
        console.dir(data);
        return this.makeRequest(this.domain + `add`, {
            method: 'POST', 
            body: data
        })
        .then(console.log)
    }

    update(id, title, content) {
        return this.makeRequest(this.domain + `update`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({id, title, content})
        })
        .then(console.log)
    }
}

export {NewsApi}