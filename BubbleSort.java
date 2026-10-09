import java.util.*;
public class BubbleSort
{
	public static void main(String args[])
	{
		int size;
		Scanner sc= new Scanner(System.in);
		System.out.println("Enter Size of Array ");
		size= sc.nextInt();
		int arr[]= new int[size];
		for(int i=0; i<size; i++)
		{
			System.out.println("Enter value = ");
			arr[i]=sc.nextInt();
		}
		System.out.println("Entered Values = ");
		for(int i=0; i<size; i++)
		{
			System.out.print(arr[i]+", ");
		}
		for(int i=0; i<size; i++)
		{
			for(int j= 0; j<size-i-1; j++)
			{
				if(arr[j]>arr[j+1])
				{
					int temp=arr[j];
					arr[j]=arr[j+1];
					arr[j+1]=temp;
				}
			}
		}
		System.out.println("\nsorted Values = ");
		for(int i=0; i<size; i++)
		{
			System.out.print(arr[i]+", ");
		}
	}
}


