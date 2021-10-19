import { useEffect } from "react";
import { useRouter } from "next/router";
import { useForm } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import * as Yup from "yup";

import { userService } from "services";


export default function Login() {
  const router = useRouter();

  useEffect(() => {
    // redirect to home if already logged in
    if (userService.userValue) {
      router.push("/");
    }

    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, []);

  
  const validationSchema = Yup.object().shape({
    email: Yup.string().required("Email is required"),
    password: Yup.string().required("Password is required"),
  });
  const formOptions = { resolver: yupResolver(validationSchema) };

  // get functions to build form with useForm() hook
  const { register, handleSubmit, setError, formState } = useForm(formOptions);
  const { errors } = formState;

  function onSubmit({ email, password }) {
    return userService
      .login(email, password)
      .then(() => {
        // get return url from query parameters or default to '/'
        const returnUrl = router.query.returnUrl || "/";
        router.push(returnUrl);
      })
      .catch((error) => {
        setError("apiError", { message: error });
      });
  }

  return (
    <div className="h-auto py-20 px-10 w-2/3 bg-indigo-500 flex flex-col space-y-5 mx-auto rounded-3xl shadow-xl transition-transform">
      <form onSubmit={handleSubmit(onSubmit)}>
        <input
          
          type="text"
          placeholder="Email"
          {...register("email")}
          className={
            (`${errors.email ? "border-red-500" : ""}`,
            "w-full mb-3 px-4 py-3 border rounded-lg text-gray-700 focus:outline-none focus:border-green-500")
          }
        />
        <div>{errors.email?.message}</div>
        <input
          type="text"
          placeholder="Password"
          className={
            (`${errors.password ? "border-red-500" : ""}`,
            "w-full mb-3 px-4 py-3 border rounded-lg text-gray-700 focus:outline-none focus:border-green-500")
          }
          {...register("password")}
        />
        <div>{errors.password?.message}</div>
        <button
          disabled={formState.isSubmitting}
          className="text-white py-3 rounded-lg w-full font-bold text-xl tracking-wider bg-green-400"
        >
          Log In
        </button>
        {errors.apiError && (
          <div className="alert alert-danger mt-3 mb-0">
            {errors.apiError?.message}
          </div>
        )}
        <div className="flex justify-center my-4">
          <a className="text-blue-500 text-sm" href="#">
            Forgot account?
          </a>
        </div>
        <hr className="" />
        <div className="flex justify-center my-6">
          <button className="text-white h-12 rounded px-6 font-bold bg-blue-600">
            Create new Account{" "}
          </button>
        </div>
      </form>
    </div>
  );
}
