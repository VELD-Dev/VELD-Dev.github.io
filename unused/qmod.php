<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="module">
        import { Octokit } from "https://cdn.skypack.dev/@octokit/rest";
    </script>
    <script>
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
    </script>
    <style>
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Q-Mod - Home</title>
    <link rel="shortcut icon" type="image/x-icon" href="resources/Q-Force_logo.png">
</head>
<body class="base-body">
    <div class="base-title-container">
        <h1 id="project-title" class="base-title">Q-Mod</h1>
        <h2 id="project-description" class="base-subtitle">The first open-source R&C Future Series mods project</h2>
        <h3 id="credits" class="base-credits">by UY-Ymir, V E L D, BellumZeldaDS</h3>
    </div>
    <div class="white-space">
        <img src="resources/background.jpg" alt="background" style="display:block; margin-right:auto; margin-left:auto; width:100%; margin-top:0px; background: url('resources/wavebar.svg') repeat-x;">
    </div>
    <div class="infos-container1">
        <h4 class="text-header">What is the Q-Mod?</h4>
        <p class="base-text01">
            The Q-Mod is basically the first publicly downloadable mod for Ratchet & Clank: Full Frontal Assault. Developed by UY-Ymir and V E L D, tested by BellumZeldaDS and some random victims.
        </p>
        <hr>
        <h4 class="text-header">Why Q-Mod is the first?</h4>
        <p class="base-text01">
            Believe it or not, Q-Mod is the first one because the other devs never went to share it. Why? We don't know. Well this is true only for weapon hacks. We're the first who are working on the game optimisation by deleting in-game components and other effects. We are also the first who patch the old bugs of the game, and re-adding old components or creating new. Oh and, know what? We'll also add weapons levels up to 10 for campaign, enemies level up to 8, still in campaign.
        </p>
        <hr>
        <h4 class="text-header">And... What is the difference between the Q-Mod and the Q-Hack?</h4>
        <p class="base-text01">
            The Q-Mod patches online and campaign components, e.g. adding slots, re-adding removed components, adding more weapons levels... But the Q-Hack is here to make weapons <b>CHEATED AS DIE</b> but only in campaign. Oh, and, it works only on client, others can see but can't use the cheat.
        </p>
        <hr>
        <h4 class="text-header">Where do I download it, and HOW??</h4>
        <p class="base-text01">
            Don't worry, we made a tutorial for how to download, and the download 
        </p>
        <hr>
    </div>
    <div class="downloads-content">
        <h4 class="download-show">Download the mod</h4>
        <h5 id="last-version" class="mod-version-text-overdownload">Getting the version...</h5>
        <h5 id="build-authors" class="mod-version-text-overdownload">Getting build author...</h5>
        <h5 id="download-count-per-versions" class="mod-version-text-overdownload">Getting download count...</h5>
        <div class="button-group">
            <a class="github-download-linker" href="https://github.com/FFA-Modding/q-mod/releases" target="_blank">
                <button class="github-button">From GitHub</button>
            </a>
            <a class="direct-download-linker" id="href-direct-download" target="_blank">
                <button id="direct-link" class="direct-link">Latest Version
                    <p class="button-file-size" id="file-size-dd">Getting file size...</p>
                    <p class="download-count-file" id="download-count-per-file">Getting file download...</p>
                </button>
            </a>
        </div>
    </div>
    <footer>
        <div class="footer">
            <p class="base-footer">
                Open-source modding projects based on Ratchet & Clank™ - Website by V E L D ©2022
            </p>
        </div>
    </footer>
</body>
</html>