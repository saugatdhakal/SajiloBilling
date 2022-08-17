import { ref } from '@vue/reactivity';
import axios from 'axios';


const getSoftDeleteSupplier = () => {
    const supplier = ref({});
    const loading = ref(true);
    const supplierError = ref({});


    const getSuppliers = async ({ page = 1, paginate,search }) => {
        await axios.get('api/supplier/getSoftDeleteSuppliers?page=' + page +
            '&paginate=' + paginate+'&search=' + search, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {

            supplier.value = res.data;
            loading.value = false;
        }).catch((resErr) => {
            supplierError.value = resErr;
            loading.value = false;
        })
    }
    return { supplier, loading, supplierError, getSuppliers }
}
export default getSoftDeleteSupplier;

