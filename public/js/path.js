
class PATH{
    
    constructor(){
        this.domain = "http://127.0.0.1:8000/";
    }

    getDomain(path) {
        return this.domain + path;
    }
}