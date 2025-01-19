window.addEventListener('DOMContentLoaded', async () => {
    const tableBody = document.querySelector('.regions'); // Jadvalning <tbody> qismi
    const response = await fetch('http://localhost:3000/hello.php?getRegion=true');
    const regions = await response.json();
    const regionsArray = Object.entries(regions).map(([region, id]) => ({ region, id }));
    regionsArray.forEach((region, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${index+1}</td>
            <td>${region.id}</td>
            <td>${region.region}</td>
            <td><button class='checkUpdateTime' id='${region.id}'>Tekshirish</button></td> <!-- Bu maydonni kerakli vaqt bilan almashtiring -->
            <td><button class='updateRegion' id='${region.id}'>
            Yangilash
            <span class="loader" style="display:none;"></span>
            </button></td>
        `;
        tableBody.appendChild(row);
    });


    const updateRegionsBtn = document.querySelectorAll('.updateRegion')
    updateRegionsBtn.forEach(updateRegionBtn => {
        updateRegionBtn.addEventListener('click', async event => {
            const idRegion = event.target.id
            const button = event.target
            const loader = document.createElement('div')
            loader.className = 'loader'
            button.replaceWith(loader)
            const result = await updateRegion(idRegion)
            if(result){
                loader.replaceWith(button)
            }else{
                loader.replaceWith(button)
                console.log("error: Problem in updated")
            }
        })
    })

    const checkUpdateTimesBtn = document.querySelectorAll('.checkUpdateTime')
    checkUpdateTimesBtn.forEach(checkUpdateTimeBtn => {
        checkUpdateTimeBtn.addEventListener('click',async (event) => {
            const regionId = event.target.id
            const button = event.target
            const loader = document.createElement('div')
            loader.className = 'loader'
            button.replaceWith(loader)
            const result = await checkUpdateRegion(regionId)
            if(result.success){
                const Text = document.createTextNode(result.update_at)
                loader.replaceWith(Text)
            }else{
                loader.replaceWith(button)
                console.log("error: Problem in updated")
            }
        })
    })

    async function updateRegion(region)
    {
        return fetch(`http://localhost:3000/hello.php?region=${region}`).then(response => {
            return true
        }).catch((error) => {
            return false
        })
    }

    async function checkUpdateRegion(region)
    {
        return fetch(`http://localhost:3000/hello.php?getTimes=${region}`).then(async response => {
            const json = await response.json()
            return json
        })
    }
});
