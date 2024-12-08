import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';

export default function Show({carriages, seat}) {
    return (
        <AuthenticatedLayout>
            <Head title="Edit Seat"/>
            Edit Seat
        </AuthenticatedLayout>
    );
}
