import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';

export default function CreateSeat({ carriages, carriage, trainSchedules, schedule_id }) {
    const { data, setData, post, processing, errors } = useForm({
        number: '',
        is_reserved: false,
        price: '',
        train_schedule_id: schedule_id || (trainSchedules && trainSchedules.length > 0 ? trainSchedules[0].id : ''),
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('carriages.seats.store', { carriage: carriage.id }), {
            onSuccess: () => {
                alert('Место успешно создано!');
            },
            onError: () => {
                alert('Ошибка при создании места. Проверьте введенные данные.');
            },
        });
    };

    return (
        <AuthenticatedLayout>
            <Head title="Создание места" />

            <div style={{
                maxWidth: '600px',
                margin: '20px auto',
                padding: '20px',
                border: '1px solid #ccc',
                borderRadius: '8px',
                backgroundColor: '#f8f9fa',
            }}>
                <h2 style={{ textAlign: 'center', marginBottom: '20px' }}>Создание места</h2>
                <form onSubmit={handleSubmit}>
                    <div style={{ marginBottom: '15px' }}>
                        <label htmlFor="seatNumber" style={{ display: 'block', marginBottom: '5px' }}>
                            Seat number:
                        </label>
                        <input
                            type="text"
                            id="seatNumber"
                            value={data.number}
                            onChange={(e) => setData('number', e.target.value)}
                            style={{
                                width: '100%',
                                padding: '10px',
                                borderRadius: '4px',
                                border: '1px solid #ccc',
                            }}
                            required
                        />
                        {errors.number && (
                            <div style={{ color: 'red', marginTop: '5px' }}>
                                {errors.number}
                            </div>
                        )}
                    </div>

                    {/* Выбор расписания */}
                    <div style={{ marginBottom: '15px' }}>
                        <label htmlFor="schedule" style={{ display: 'block', marginBottom: '5px' }}>
                            Schedule:
                        </label>
                        <select
                            id="schedule"
                            value={data.train_schedule_id}
                            onChange={(e) => setData('train_schedule_id', e.target.value)}
                            style={{
                                width: '100%',
                                padding: '10px',
                                borderRadius: '4px',
                                border: '1px solid #ccc',
                            }}
                            required
                        >
                            <option value="">Выберите расписание</option>
                            {trainSchedules && trainSchedules.map((schedule) => (
                                <option key={schedule.id} value={schedule.id}>
                                    {new Date(schedule.departure).toLocaleString()} - {new Date(schedule.arrival).toLocaleString()}
                                </option>
                            ))}
                        </select>
                        {errors.train_schedule_id && (
                            <div style={{ color: 'red', marginTop: '5px' }}>
                                {errors.train_schedule_id}
                            </div>
                        )}
                    </div>

                    <div style={{ marginBottom: '15px' }}>
                        <label htmlFor="price" style={{ display: 'block', marginBottom: '5px' }}>
                            Price:
                        </label>
                        <input
                            type="number"
                            id="price"
                            value={data.price}
                            onChange={(e) => setData('price', e.target.value)}
                            style={{
                                width: '100%',
                                padding: '10px',
                                borderRadius: '4px',
                                border: '1px solid #ccc',
                            }}
                            required
                        />
                        {errors.price && (
                            <div style={{ color: 'red', marginTop: '5px' }}>
                                {errors.price}
                            </div>
                        )}
                    </div>

                    <div style={{ marginBottom: '15px' }}>
                        <label style={{ display: 'block', marginBottom: '5px' }}>
                            Reserved:
                        </label>
                        <input
                            type="checkbox"
                            id="isReserved"
                            checked={data.is_reserved}
                            onChange={(e) => setData('is_reserved', e.target.checked)}
                        />
                        {errors.is_reserved && (
                            <div style={{ color: 'red', marginTop: '5px' }}>
                                {errors.is_reserved}
                            </div>
                        )}
                    </div>

                    <button
                        type="submit"
                        disabled={processing}
                        style={{
                            display: 'block',
                            width: '100%',
                            padding: '10px',
                            backgroundColor: '#007bff',
                            color: '#fff',
                            border: 'none',
                            borderRadius: '4px',
                            cursor: processing ? 'not-allowed' : 'pointer',
                        }}
                    >
                        {processing ? 'Создание...' : 'Создать место'}
                    </button>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
