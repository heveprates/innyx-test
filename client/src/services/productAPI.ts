import { ProductNotFoundError } from "@/error/ProductError";
import { Server } from "./serviceAPI";

export class ProductAPIFetch {
  static async listPage(
    page: number,
    search: string
  ): Promise<ProductFetchResponse> {
    try {
      const {
        data: { data, meta },
      } = await Server.APIAuthInstance.get<ProductAPIFetchData>(
        `/api/products`,
        {
          params: {
            page,
            search: search || undefined,
          },
        }
      );
      return {
        data: data.map((product: ProductAPIType) => ({
          id: String(product.id),
          name: product.name,
          description: product.description,
          price: product.price,
          valid: new Date(product.valid),
          imageUrl: product.imageUrl,
        })),
        pagination: {
          current: meta.current_page,
          last: meta.last_page,
          total: meta.total,
        },
      };
    } catch (error: any) {
      if (error?.response?.data?.message) {
        throw new ProductNotFoundError(error?.response?.data?.message);
      }

      throw error;
    }
  }

  static async store(product: {
    name: string;
    description: string;
    price: number;
    valid: Date;
    imageFile: File;
    category: string;
  }): Promise<string> {
    try {
      const formData = new FormData();
      formData.append("name", product.name);
      formData.append("description", product.description);
      formData.append("price", String(product.price));
      formData.append("date_validity", product.valid.toISOString());
      formData.append("image", product.imageFile);
      formData.append("category_id", product.category);
      const { data } = await Server.APIAuthInstance.post<ProductAPIType>(
        `/api/products`,
        formData
      );
      return String(data.id);
    } catch (error: any) {
      if (error?.response?.data?.message) {
        throw new ProductNotFoundError(error?.response?.data?.message);
      }

      throw error;
    }
  }

  static async show(id: string): Promise<ProductAPIDetail> {
    try {
      const { data } = await Server.APIAuthInstance.get<{
        product: ProductAPIDetail;
      }>(`/api/products/${id}`);
      return {
        id: String(data.product.id),
        name: data.product.name,
        description: data.product.description,
        price: data.product.price,
        valid: new Date(data.product.valid),
        imageUrl: data.product.imageUrl,
        categoryId: String(data.product.categoryId),
      };
    } catch (error: any) {
      if (error?.response?.data?.message) {
        throw new ProductNotFoundError(error?.response?.data?.message);
      }

      throw error;
    }
  }

  static async update(
    id: string,
    product: Partial<{
      name: string | null;
      description: string | null;
      price: number | null;
      valid: Date | null;
      image: File | null;
    }>
  ): Promise<string> {
    const formData = new FormData();
    let submitForm = false;
    if (product.name) {
      submitForm = true;
      formData.append("name", product.name);
    }
    if (product.description) {
      submitForm = true;
      formData.append("description", product.description);
    }
    if (product.price) {
      submitForm = true;
      formData.append("price", String(product.price));
    }
    if (product.valid) {
      submitForm = true;
      formData.append("valid", product.valid.toISOString());
    }
    if (product.image) {
      submitForm = true;
      formData.append("imageUrl", product.image);
    }
    if (!submitForm) {
      return id;
    }
    formData.append("_method", "PUT");
    try {
      await Server.APIAuthInstance.post(`/api/products/${id}`, formData);
      return id;
    } catch (error: any) {
      if (error?.response?.data?.message) {
        throw new ProductNotFoundError(error?.response?.data?.message);
      }

      throw error;
    }
  }

  static async delete(id: string): Promise<void> {
    try {
      await Server.APIAuthInstance.delete(`/api/products/${id}`);
    } catch (error: any) {
      if (error?.response?.data?.message) {
        throw new ProductNotFoundError(error?.response?.data?.message);
      }

      throw error;
    }
  }
}

type ProductAPIFetchData = {
  data: ProductAPIType[];
  meta: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
  };
};

type ProductFetchResponse = {
  data: Product[];
  pagination: {
    current: number;
    last: number;
    total: number;
  };
};

type ProductAPIType = {
  id: number;
  name: string;
  description: string;
  price: number;
  valid: string;
  imageUrl: string;
};

type Product = {
  id: string;
  name: string;
  description: string;
  price: number;
  valid: Date;
  imageUrl: string;
};

type ProductAPIDetail = {
  id: string;
  name: string;
  description: string;
  price: number;
  valid: Date;
  imageUrl: string;
  categoryId: string;
};
