import { ref } from "@vue/reactivity";
import axios from "axios";

const getSuppliersNames =()=>{
    const supplier = ref([]);
    const loading = ref(false);
    const getNames = async(search)=>{
        await axios.get('api/supplier/getSuppliersNames?q='+search,{
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            loading.value= false;
            supplier.value = res.data;
        });
    };
    return {supplier,getNames,loading};
}
export default getSuppliersNames;
