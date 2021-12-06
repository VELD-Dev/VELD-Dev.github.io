
console.log("JavaScript loaded.")
let version;
getLastVersionInfo().then(versionRef => {
    version = versionRef;
    console.log(version.tag_name)
    $("#last-version").html(`Version name: <b>${version.name}</b>`)
    $("#build-authors").html(`Build author: ${version.author.login}`)
})
getLastPSARC().then(fileRef => {
    let fileSize = (parseFloat(fileRef.size) / 1000).toFixed(2)
    console.log(fileRef)
    $("#href-direct-download").attr("href", fileRef.browser_download_url)
    $("#file-size-dd").html(`(${fileRef.name} ${fileSize}KB)`)
    $("#download-count-per-file").html(`(File downloads: ${fileRef.download_count})`)
})
getTotalDownloads().then(dlCount => {
    $("#download-count-per-versions").html(`Total downloads: ${dlCount}`)
})

async function getLastVersionInfo() {
    return new Promise(async (resolve, reject) => {
        let result = await getJSON("https://api.github.com/repos/FFA-Modding/q-mod/releases");
        resolve(result[0]);
    });
};

async function getLastPSARC() {
    return new Promise(async (resolve, reject) => {
        let result = await getJSON("https://api.github.com/repos/FFA-Modding/q-mod/releases");
        result[0].assets.forEach(file => {
            if(file.name.startsWith('patch_') && file.name.endsWith('.psarc')) {
                resolve(file);
            }
        })
    });
}

async function getTotalDownloads() {
    return new Promise(async (resolve, reject) => {
        let dlCount = 0;
        let result = await getJSON("https://api.github.com/repos/FFA-Modding/q-mod/releases")
        result.forEach(res => {
            res.assets.forEach(file => {
                dlCount = dlCount + file.download_count;
                //console.log(`FileDL[${file.name}]: ${file.download_count} | Tot.DL: ${dlCount}`)
            })
        })
        resolve(dlCount)
    })
}

async function getJSON(url) {
    let result = await fetch(url)
    if(result){
        result = await result.json()
    }else{
        result = { error: "An error as occured" }
    }
    return result
};
    