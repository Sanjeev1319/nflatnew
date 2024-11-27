import PrimaryButton from "@/Components/PrimaryButton";
import SecondaryButton from "@/Components/SecondaryButton";
import ExamScreenLayout from "@/Layouts/ExamScreenLayout";
import { Head, useForm } from "@inertiajs/react";
import { useEffect, useState } from "react";

export default function Exam({ student_uuid, questions, timeLeft }) {
	const { data, setData, post, processing, errors, reset, setError } = useForm({
		answers: "",
		student_uuid: student_uuid,
	});

	const [currentCategoryIndex, setCurrentCategoryIndex] = useState(0);
	const [currentQuestionIndex, setCurrentQuestionIndex] = useState(0);
	// Initialize answers from localStorage
	const [answers, setAnswers] = useState(() => {
		const savedAnswers = localStorage.getItem("quiz_answers");
		return savedAnswers ? JSON.parse(savedAnswers) : {};
	});

	const [remainingTime, setRemainingTime] = useState(() => {
		// Load timer from localStorage or set to initial value
		const storedTime = localStorage.getItem("quiz_timer");
		return storedTime ? parseInt(storedTime, 10) : timeLeft * 60;
	});

	const categories = questions.categories;
	const currentCategory = categories[currentCategoryIndex];
	const currentQuestion = currentCategory.questions[currentQuestionIndex];

	// Save answers to localStorage whenever they change
	useEffect(() => {
		localStorage.setItem("quiz_answers", JSON.stringify(answers));
		setData("answers", answers);
	}, [answers]);

	// Save remaining time to localStorage every second
	useEffect(() => {
		localStorage.setItem("quiz_timer", remainingTime.toString());
	}, [remainingTime]);

	// Disable keyboard events
	useEffect(() => {
		const disableKeyboardEvents = (event) => {
			event.preventDefault();
		};

		window.addEventListener("keydown", disableKeyboardEvents);
		window.addEventListener("keypress", disableKeyboardEvents);

		return () => {
			window.removeEventListener("keydown", disableKeyboardEvents);
			window.removeEventListener("keypress", disableKeyboardEvents);
		};
	}, []);

	// Disable browser refresh via navigation events
	useEffect(() => {
		const handleBeforeUnload = (event) => {
			event.preventDefault();
			event.returnValue = "";
		};

		window.addEventListener("beforeunload", handleBeforeUnload);

		return () => {
			window.removeEventListener("beforeunload", handleBeforeUnload);
		};
	}, []);

	// Timer logic
	useEffect(() => {
		const timer = setInterval(() => {
			setRemainingTime((prevTime) => {
				if (prevTime <= 1) {
					clearInterval(timer);
					handleSubmit(); // Automatically submit when time is up
					return 0;
				}
				return prevTime - 1;
			});
		}, 1000);

		return () => clearInterval(timer);
	}, []);

	// Format time (MM:SS)
	const formatTime = (time) => {
		const minutes = Math.floor(time / 60);
		const seconds = time % 60;
		return `${minutes.toString().padStart(2, "0")}:${seconds
			.toString()
			.padStart(2, "0")}`;
	};

	// Handle option selection
	const handleOptionSelect = (questionId, optionKey) => {
		const updatedAnswers = { ...answers, [questionId]: optionKey };
		setAnswers(updatedAnswers);
		localStorage.setItem("quiz_answers", JSON.stringify(updatedAnswers));
	};

	// Handle category selection
	const handleCategorySelect = (index) => {
		setCurrentCategoryIndex(index);
		setCurrentQuestionIndex(0);
	};

	// Handle question selection
	const handleQuestionSelect = (index) => {
		setCurrentQuestionIndex(index);
	};

	// Handle navigation
	const handleNext = () => {
		if (currentQuestionIndex < currentCategory.questions.length - 1) {
			setCurrentQuestionIndex(currentQuestionIndex + 1);
		} else if (currentCategoryIndex < categories.length - 1) {
			setCurrentCategoryIndex(currentCategoryIndex + 1);
			setCurrentQuestionIndex(0);
		}
	};

	const handlePrevious = () => {
		if (currentQuestionIndex > 0) {
			setCurrentQuestionIndex(currentQuestionIndex - 1);
		} else if (currentCategoryIndex > 0) {
			setCurrentCategoryIndex(currentCategoryIndex - 1);
			setCurrentQuestionIndex(
				categories[currentCategoryIndex - 1].questions.length - 1
			);
		}
	};

	// Submit quiz
	const handleSubmit = () => {
		console.log("Submitting Data:", {
			student_uuid: student_uuid,
			answers: answers,
		});

		post(route("student.quiz.submit"), {
			data,
			onSuccess: () => {
				console.log("Submission Successful!");
				localStorage.removeItem("quiz_answers");
				localStorage.removeItem("quiz_timer");
			},
			onError: (error) => {
				console.error("Submission Error:", error);
			},
		});
	};

	return (
		<ExamScreenLayout>
			<Head title="Instructions" />

			<div className="grid grid-cols-1 md:grid-cols-1 gap-4 py-8 md:px-8 lg:grid-cols-12">
				<div className="lg:col-span-8 sm:col-span-1">
					<div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
						<div className="p-6 text-gray-900">
							<form className="quiz-container">
								<div className="question-section">
									<h3>
										<strong>Question {currentQuestionIndex + 1}:</strong>{" "}
									</h3>
									<h2>{currentQuestion.question}</h2>
									<h3 className="mt-4">
										<strong>Options:</strong>{" "}
									</h3>
									<div className="lg:w-2/4 md:w-2/3">
										{["option_a", "option_b", "option_c", "option_d"].map(
											(key, index) => (
												<SecondaryButton
													key={index}
													className={`flex w-full my-3 py-4 hover:bg-green-300 focus:bg-green-500 ${
														answers[currentQuestion.id] === key
															? " bg-green-400 text-green-950 "
															: ""
													}`}
													onClick={() =>
														handleOptionSelect(currentQuestion.id, key)
													}
												>
													{String.fromCharCode(65 + index)}.{" "}
													{currentQuestion[key]}
												</SecondaryButton>
											)
										)}
									</div>
								</div>
								<div className="flex py-5">
									<PrimaryButton
										onClick={handlePrevious}
										disabled={
											currentCategoryIndex === 0 && currentQuestionIndex === 0
										}
										className="me-5"
									>
										Previous
									</PrimaryButton>
									<PrimaryButton
										onClick={handleNext}
										disabled={
											currentCategoryIndex === categories.length - 1 &&
											currentQuestionIndex ===
												currentCategory.questions.length - 1
										}
										className="me-5"
									>
										Next
									</PrimaryButton>
									<PrimaryButton
										onClick={handleSubmit}
										className="bg-green-700 hover:bg-green-600"
									>
										Submit
									</PrimaryButton>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div className="lg:col-span-4">
					<div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
						<div className="p-6 text-gray-900 border-b">
							<div className="text-center">
								<h2 className="text-lg font-bold">
									Time Remaining:{" "}
									<span className="text-red-600">
										{formatTime(remainingTime)}
									</span>
								</h2>
							</div>
						</div>
						<div className="p-6 text-gray-900">
							<div className="grid grid-cols-2 pb-6 gap-4">
								{categories.map((category, index) => (
									<PrimaryButton
										key={index}
										className={`flex justify-center hover:bg-indigo-400 active:bg-indigo-700 focus:bg-indigo-700 ${
											index === currentCategoryIndex ? "bg-indigo-700" : ""
										}`}
										onClick={() => handleCategorySelect(index)}
									>
										{category.category_name}
									</PrimaryButton>
								))}
							</div>
						</div>
						<div className="p-6 text-gray-900 border-t">
							<div className="grid grid-cols-5 gap-6 ">
								{currentCategory.questions.map((question, index) => (
									<PrimaryButton
										key={index}
										className={`flex justify-center hover:bg-indigo-400 active:bg-indigo-700 focus:bg-indigo-700 ${
											index === currentQuestionIndex
												? "bg-indigo-700"
												: answers[question.id]
												? "bg-green-500"
												: ""
										}`}
										onClick={() => handleQuestionSelect(index)}
									>
										{index + 1}
									</PrimaryButton>
								))}
							</div>
						</div>
					</div>
				</div>
			</div>
		</ExamScreenLayout>
	);
}
