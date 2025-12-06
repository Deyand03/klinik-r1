const btnPeriksa = document.getElementsByClassName("btn-periksa");
const url = "http://localhost:8001";
const container = document.getElementById("container-modal");
const idDokter = document.getElementById("id-dokter").innerText;
console.log(idDokter);
async function getDetailKunjunganFromApi(id){
    const response = await fetch(`${url}/staff/kunjungan/detail?id=${id}`);
    if(!response.ok){
        throw new Error(response.status);
    }
    const data = await response.json();
    return data;
}

for(let i = 0; i < btnPeriksa.length; i++)
{
    btnPeriksa[i].addEventListener("click", async function(){
        try{
            const response = await getDetailKunjunganFromApi(btnPeriksa[i].dataset.id);
            const formDiagnosa = document.getElementById("form-diagnosa");
            const rekamMedis = document.getElementById("rekam_medis");
            rekamMedis.value = response.data.id;
            formDiagnosa.setAttribute("action", `${url}/staff/kunjungan/resep/${btnPeriksa[i].dataset.id}`);


            const anamnesa = document.getElementById("anamnesa");
            const vital = document.getElementById("vital-signs");
            anamnesa.innerText = response.data.anamnesa;
            vital.innerText = `${response.data.tensi_darah}: ${response.data.suhu_badan}: ${response.data.berat_badan}`;

        }catch(error){
            console.error(error);
        }
    });
}