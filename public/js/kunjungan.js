const btnPeriksa = document.getElementsByClassName("btn-periksa");
const url = "https://baas-klinik.vercel.app/api/api/";
const container = document.getElementById("container-modal");
const idDokter = document.getElementById("id-dokter").innerText;

async function getDetailKunjunganFromApi(id){
    // Perbaikan: Menggunakan backtick (`) untuk template literal
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
            console.log(formDiagnosa);
            const rekamMedis = document.getElementById("rekam_medis");
            rekamMedis.value = response.data.id;
            
            // Perbaikan: Menggunakan backtick (`) untuk template literal
            formDiagnosa.setAttribute("action", `${url}/staff/kunjungan/resep/${btnPeriksa[i].dataset.id}`);

            console.log(formDiagnosa);
            const anamnesa = document.getElementById("anamnesa");
            const vital = document.getElementById("vital-signs");
            anamnesa.innerText = response.data.anamnesa;
            
            // Perbaikan: Menggunakan backtick (`) untuk template literal
            vital.innerText = `${response.data.tensi_darah}: ${response.data.suhu_badan}: ${response.data.berat_badan}`;

        } catch(error) {
            console.error(error);
        } 
    });
}