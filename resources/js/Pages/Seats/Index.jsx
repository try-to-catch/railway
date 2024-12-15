import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import { Head, useForm } from '@inertiajs/react'
import { useState } from 'react'

export default function Index ({ seats }) {
    const { data, setData, post, processing } = useForm({
        seats: seats.data
    })

    const [searchQuery, setSearchQuery] = useState('')

    const handleReserve = seatId => {
        const updatedSeats = data.seats.map(seat =>
            seat.id === seatId ? { ...seat, is_reserved: true } : seat
        )

        setData('seats', updatedSeats)

        post(route('seats.reserve', { seat: seatId }), {
            onError: () => {
                const revertedSeats = data.seats.map(seat =>
                    seat.id === seatId ? { ...seat, is_reserved: false } : seat
                )
                setData('seats', revertedSeats)
                alert('Failed to reserve the seat. Please try again.')
            },
            onSuccess: () => {
                alert('Seat reserved successfully!')
            }
        })
    }

    const filteredSeats = data.seats.filter(seat => {
        return seat.number.toLowerCase().includes(searchQuery.toLowerCase())
    })

    return (
        <AuthenticatedLayout>
            <Head title='Seats' />
            <div
                style={{
                    padding: '20px',
                    display: 'flex',
                    flexDirection: 'column',
                    alignItems: 'center'
                }}
            >
                <input
                    type='text'
                    placeholder='Search by seat number...'
                    value={searchQuery}
                    onChange={e => setSearchQuery(e.target.value)}
                    style={{
                        padding: '10px',
                        width: '300px',
                        marginBottom: '20px',
                        borderRadius: '5px',
                        border: '1px solid #ccc'
                    }}
                />

                <div
                    style={{
                        display: 'flex',
                        flexWrap: 'wrap',
                        gap: '20px',
                        justifyContent: 'center'
                    }}
                >
                    {filteredSeats.map((seat, index) => (
                        <div
                            key={index}
                            style={{
                                textDecoration: 'none',
                                display: 'block',
                                border: '1px solid #ccc',
                                borderRadius: '8px',
                                padding: '20px',
                                minWidth: '200px',
                                textAlign: 'center',
                                backgroundColor: seat.is_reserved
                                    ? '#f8d7da'
                                    : '#d4edda',
                                boxShadow: '0 4px 6px rgba(0, 0, 0, 0.1)',
                                color: seat.is_reserved ? '#721c24' : '#155724'
                            }}
                        >
                            <h3 style={{ marginBottom: '15px' }}>
                                Seat {seat.number}
                            </h3>
                            <ul style={{ listStyle: 'none', padding: 0 }}>
                                <li style={{ marginBottom: '10px' }}>
                                    <strong>ID:</strong> {seat.id}
                                </li>
                                <li style={{ marginBottom: '10px' }}>
                                    <strong>Reserved:</strong>{' '}
                                    {seat.is_reserved ? 'Yes' : 'No'}
                                </li>
                                <li style={{ marginBottom: '10px' }}>
                                    <strong>Number:</strong> {seat.number}
                                </li>
                            </ul>

                            {!seat.is_reserved && (
                                <button
                                    onClick={() => handleReserve(seat.id)}
                                    disabled={processing}
                                    style={{
                                        padding: '10px 20px',
                                        backgroundColor: '#28a745',
                                        color: 'white',
                                        borderRadius: '5px',
                                        fontSize: '16px',
                                        border: 'none',
                                        cursor: processing
                                            ? 'not-allowed'
                                            : 'pointer'
                                    }}
                                >
                                    {processing ? 'Reserving...' : 'Reserve'}
                                </button>
                            )}
                        </div>
                    ))}
                </div>
            </div>
        </AuthenticatedLayout>
    )
}
