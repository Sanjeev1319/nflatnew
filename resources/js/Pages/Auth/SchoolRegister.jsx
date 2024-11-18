import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { useState } from 'react';

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        school_name: '',
        school_email: '',
        school_email_otp: '',
        school_mobile: '',
        school_mobile_otp: '',
        password: '',
        password_confirmation: '',
    });

    const [emailOtpSent, setEmailOtpSent] = useState(false);
    const [emailVerified, setEmailVerified] = useState(false);
    const [mobileOtpSent, setMobileOtpSent] = useState(false);
    const [mobileVerified, setMobileVerified] = useState(false);

    const sendEmailOtp = () => {
        axios.post('/send-email-otp', { email: data.school_email })
            .then(() => setEmailOtpSent(true))
            .catch(error => console.error(error));
    };

    const verifyEmailOtp = () => {
        axios.post('/verify-email-otp', { otp: data.school_email_otp })
            .then(() => setEmailVerified(true))
            .catch(error => console.error(error));
    };

    const sendMobileOtp = () => {
        axios.post('/send-mobile-otp', { mobile: data.school_mobile })
            .then(() => setMobileOtpSent(true))
            .catch(error => console.error(error));
    };

    const verifyMobileOtp = () => {
        axios.post('/verify-mobile-otp', { otp: data.school_mobile_otp })
            .then(() => setMobileVerified(true))
            .catch(error => console.error(error));
    };

    const submit = (e) => {
        e.preventDefault();
        post(route('register'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };


    return (
        <GuestLayout>
            <Head title="Register" />

            <form onSubmit={submit}>
            <div>
                <InputLabel htmlFor="school_name" value="School Name" />
                <TextInput
                    id="school_name"
                    value={data.school_name}
                    onChange={(e) => setData('school_name', e.target.value)}
                    required
                />
                <InputError message={errors.school_name} />
            </div>

            <div>
                <InputLabel htmlFor="school_email" value="School Email" />
                <TextInput
                    id="school_email"
                    type="email"
                    value={data.school_email}
                    onChange={(e) => setData('school_email', e.target.value)}
                    disabled={emailOtpSent || emailVerified}
                    required
                />
                {!emailOtpSent && (
                    <PrimaryButton onClick={sendEmailOtp}>
                        Send OTP
                    </PrimaryButton>
                )}
                {emailOtpSent && !emailVerified && (
                    <>
                        <TextInput
                            id="school_email_otp"
                            type="text"
                            value={data.school_email_otp}
                            onChange={(e) => setData('school_email_otp', e.target.value)}
                            required
                        />
                        <PrimaryButton onClick={verifyEmailOtp}>
                            Verify OTP
                        </PrimaryButton>
                    </>
                )}
                <InputError message={errors.school_email} />
            </div>

            <div>
                <InputLabel htmlFor="school_mobile" value="School Mobile" />
                <TextInput
                    id="school_mobile"
                    type="text"
                    value={data.school_mobile}
                    onChange={(e) => setData('school_mobile', e.target.value)}
                    disabled={mobileOtpSent || mobileVerified}
                    required
                />
                {!mobileOtpSent && (
                    <PrimaryButton onClick={sendMobileOtp}>
                        Send OTP
                    </PrimaryButton>
                )}
                {mobileOtpSent && !mobileVerified && (
                    <>
                        <TextInput
                            id="school_mobile_otp"
                            type="text"
                            value={data.school_mobile_otp}
                            onChange={(e) => setData('school_mobile_otp', e.target.value)}
                            required
                        />
                        <PrimaryButton onClick={verifyMobileOtp}>
                            Verify OTP
                        </PrimaryButton>
                    </>
                )}
                <InputError message={errors.school_mobile} />
            </div>

            <PrimaryButton disabled={!emailVerified || !mobileVerified}>
                Register
            </PrimaryButton>
        </form>

        </GuestLayout>
    );
}
