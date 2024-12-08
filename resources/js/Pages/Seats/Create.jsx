import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';

export default function Show({carriages}) {
    return (
        <AuthenticatedLayout>
            <Head title="Create Seat"/>

            Create Seat
        </AuthenticatedLayout>
    );
}
