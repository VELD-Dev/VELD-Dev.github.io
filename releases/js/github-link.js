console.log("JavaScript loaded.")

getEachAsset().then(async assets => {
    assets.forEach(async asset => {
        let eachAssetSizeAdditionned = 0;
        for(let i = 0; i < asset.assets.length; i++) {
            eachAssetSizeAdditionned = parseFloat(eachAssetSizeAdditionned) + parseFloat((asset.assets[i].size / 1000).toFixed(2))
            if(eachAssetSizeAdditionned < 999.99) {
                eachAssetSizeAdditionned = eachAssetSizeAdditionned + " KB";
            } else if(eachAssetSizeAdditionned > 999.99) {
                eachAssetSizeAdditionned = parseFloat((eachAssetSizeAdditionned / 1000).toFixed(2)) + " MB"
            }
        }
        $("#releaseTable > tbody:last-child").append(`<tr>
            <td>${asset.name}</td>
            <td><a href="${asset.author.html_url}">${asset.author.login}</a></td>
            <td>${asset.published_at.slice(0, 10)}</td>
            <td><a href="${asset.html_url}">Download</a></td>
            <td>${(eachAssetSizeAdditionned)}</td>
            </tr>`)
        console.log(`Asset added (release ${asset.tag_name})`)
        console.log(eachAssetSizeAdditionned)
    })
})


/////////////////
//             //
//  FUNCTIONS  //
//             //
/////////////////

async function getEachAsset() {
    return new Promise(async (resolve, reject) => {
        let results = getJSON("https://api.github.com/repos/FFA-Modding/q-mod/releases");
        resolve(results);
    });
};

function compare(a, b) {
    return new Date(b.date) - new Date(a.date)
}

async function getJSON(url) {
    let result = await fetch(url);
    if(result){
        result = await result.json();
    }else{
        result = { error: `An error as occured\nError:${result.text}` };
    };
    return result;
};